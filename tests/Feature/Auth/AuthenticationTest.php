<?php

use App\Models\User;

test('login screen can be rendered', function () {
    $response = $this->get('/login');

    $response->assertStatus(200);
});

test('users can authenticate using the login screen', function () {
    $user = User::factory()->create();

    $response = $this->withSession(['captcha_result' => 10])->post('/login', [
        'email' => $user->email,
        'password' => 'password',
        'captcha' => 10,
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('dashboard', absolute: false));
});

test('users can not authenticate with invalid password', function () {
    $user = User::factory()->create();

    $this->withSession(['captcha_result' => 10])->post('/login', [
        'email' => $user->email,
        'password' => 'wrong-password',
        'captcha' => 10,
    ]);

    $this->assertGuest();
});

test('login is rejected when the captcha answer is wrong', function () {
    $user = User::factory()->create();

    $this->withSession(['captcha_result' => 10])->post('/login', [
        'email' => $user->email,
        'password' => 'password',
        'captcha' => 9,
    ])->assertSessionHasErrors('captcha');

    $this->assertGuest();
});

test('users can logout', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post('/logout');

    $this->assertGuest();
    $response->assertRedirect('/');
});
