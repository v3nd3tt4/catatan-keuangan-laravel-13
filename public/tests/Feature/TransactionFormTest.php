<?php

use App\Models\Category;
use App\Models\User;

test('transaction create form exposes category type data for filtering', function () {
    $user = User::factory()->create();
    Category::create([
        'user_id' => $user->id,
        'name' => 'Gaji',
        'type' => 'income',
    ]);
    Category::create([
        'user_id' => $user->id,
        'name' => 'Makan',
        'type' => 'expense',
    ]);

    $response = $this->actingAs($user)->get(route('transactions.create'));

    $response->assertOk();
    $response->assertSee('data-type="income"', false);
    $response->assertSee('data-type="expense"', false);
});
