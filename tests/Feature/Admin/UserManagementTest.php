<?php

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;

test('admin can open the user management page', function () {
    $admin = User::factory()->admin()->create();
    $user = User::factory()->unverified()->create();

    $response = $this->actingAs($admin)->get(route('admin.users'));

    $response->assertOk();
    $response->assertSee($user->email);
    $response->assertSee('Belum Terverifikasi');
    $response->assertSee(route('admin.users.verify', $user), false);
    $response->assertSee(route('admin.users.password', $user), false);
});

test('user management page does not list admin accounts', function () {
    $admin = User::factory()->admin()->create();
    $otherAdmin = User::factory()->admin()->create();

    $response = $this->actingAs($admin)->get(route('admin.users'));

    $response->assertOk();
    $response->assertDontSee($otherAdmin->email);
});

test('regular user cannot manage users', function () {
    $user = User::factory()->create();
    $target = User::factory()->unverified()->create();

    $this->actingAs($user)->get(route('admin.users'))->assertForbidden();
    $this->actingAs($user)->patch(route('admin.users.verify', $target))->assertForbidden();
    $this->actingAs($user)->delete(route('admin.users.unverify', $target))->assertForbidden();
    $this->actingAs($user)->patch(route('admin.users.password', $target), [
        'password' => 'rahasia123',
        'password_confirmation' => 'rahasia123',
    ])->assertForbidden();
});

test('guest cannot manage users', function () {
    $target = User::factory()->unverified()->create();

    $this->patch(route('admin.users.verify', $target))->assertRedirect(route('login'));
    $this->patch(route('admin.users.password', $target))->assertRedirect(route('login'));
});

test('admin can verify a user email', function () {
    $admin = User::factory()->admin()->create();
    $user = User::factory()->unverified()->create();

    Event::fake();

    $response = $this->actingAs($admin)->patch(route('admin.users.verify', $user));

    Event::assertDispatched(Verified::class);
    expect($user->fresh()->hasVerifiedEmail())->toBeTrue();
    $response->assertSessionHas('success');
});

test('admin cannot verify an already verified user', function () {
    $admin = User::factory()->admin()->create();
    $user = User::factory()->create();

    Event::fake();

    $response = $this->actingAs($admin)->patch(route('admin.users.verify', $user));

    Event::assertNotDispatched(Verified::class);
    $response->assertSessionHas('warning');
});

test('admin can cancel a user email verification', function () {
    $admin = User::factory()->admin()->create();
    $user = User::factory()->create();

    $response = $this->actingAs($admin)->delete(route('admin.users.unverify', $user));

    expect($user->fresh()->hasVerifiedEmail())->toBeFalse();
    $response->assertSessionHas('success');
});

test('admin cannot cancel verification of an unverified user', function () {
    $admin = User::factory()->admin()->create();
    $user = User::factory()->unverified()->create();

    $response = $this->actingAs($admin)->delete(route('admin.users.unverify', $user));

    expect($user->fresh()->hasVerifiedEmail())->toBeFalse();
    $response->assertSessionHas('warning');
});

test('admin can change a user password', function () {
    $admin = User::factory()->admin()->create();
    $user = User::factory()->create();

    Event::fake();

    $response = $this->actingAs($admin)->patch(route('admin.users.password', $user), [
        '_user_id' => $user->id,
        'password' => 'rahasia-terbaru',
        'password_confirmation' => 'rahasia-terbaru',
    ]);

    Event::assertDispatched(PasswordReset::class);
    expect(Hash::check('rahasia-terbaru', $user->fresh()->password))->toBeTrue();
    $response->assertSessionHas('success');
    $response->assertSessionHasNoErrors();
});

test('new user password must be confirmed and long enough', function () {
    $admin = User::factory()->admin()->create();
    $user = User::factory()->create();
    $oldPassword = $user->password;

    $this->actingAs($admin)->patch(route('admin.users.password', $user), [
        '_user_id' => $user->id,
        'password' => 'pendek',
        'password_confirmation' => 'pendek',
    ])->assertSessionHasErrors('password');

    $this->actingAs($admin)->patch(route('admin.users.password', $user), [
        '_user_id' => $user->id,
        'password' => 'rahasia-terbaru',
        'password_confirmation' => 'rahasia-lama',
    ])->assertSessionHasErrors('password');

    expect($user->fresh()->password)->toBe($oldPassword);
});

test('admin cannot manage another admin account', function () {
    $admin = User::factory()->admin()->create();
    $otherAdmin = User::factory()->admin()->unverified()->create();
    $oldPassword = $otherAdmin->password;

    $this->actingAs($admin)->patch(route('admin.users.verify', $otherAdmin))->assertForbidden();
    $this->actingAs($admin)->delete(route('admin.users.unverify', $admin))->assertForbidden();
    $this->actingAs($admin)->patch(route('admin.users.password', $otherAdmin), [
        'password' => 'rahasia123',
        'password_confirmation' => 'rahasia123',
    ])->assertForbidden();

    expect($otherAdmin->fresh()->hasVerifiedEmail())->toBeFalse();
    expect($otherAdmin->fresh()->password)->toBe($oldPassword);
});
