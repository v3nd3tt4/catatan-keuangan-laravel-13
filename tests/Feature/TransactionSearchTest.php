<?php

use App\Models\Category;
use App\Models\Transaction;
use App\Models\User;

function createTransaction(User $user, string $description, string $type = 'expense', ?string $categoryName = null): Transaction
{
    $category = Category::create([
        'user_id' => $user->id,
        'name' => $categoryName ?? 'Umum',
        'type' => $type,
    ]);

    return Transaction::create([
        'user_id' => $user->id,
        'category_id' => $category->id,
        'type' => $type,
        'amount' => 25000,
        'date' => now()->format('Y-m-d'),
        'description' => $description,
    ]);
}

test('transaction list can be searched by description', function () {
    $user = User::factory()->create();
    createTransaction($user, 'Bayar listrik');
    createTransaction($user, 'Beli buku');

    $response = $this->actingAs($user)->get(route('transactions.index', ['search' => 'listrik']));

    $response->assertOk();
    $response->assertSee('Bayar listrik');
    $response->assertDontSee('Beli buku');
});

test('transaction list can be searched by category name', function () {
    $user = User::factory()->create();
    createTransaction($user, 'Makan siang', 'expense', 'Makan');
    createTransaction($user, 'Baju baru', 'expense', 'Belanja');

    $response = $this->actingAs($user)->get(route('transactions.index', ['search' => 'belanja']));

    $response->assertOk();
    $response->assertSee('Baju baru');
    $response->assertDontSee('Makan siang');
});

test('transaction list can be searched by type label', function () {
    $user = User::factory()->create();
    createTransaction($user, 'Gaji bulan ini', 'income');
    createTransaction($user, 'Bayar kos', 'expense');

    $response = $this->actingAs($user)->get(route('transactions.index', ['search' => 'pemasukan']));

    $response->assertOk();
    $response->assertSee('Gaji bulan ini');
    $response->assertDontSee('Bayar kos');
});

test('transaction search only matches the current user transactions', function () {
    $user = User::factory()->create();
    $other = User::factory()->create();
    createTransaction($user, 'Bayar listrik');
    createTransaction($other, 'Bayar listrik tetangga');

    $response = $this->actingAs($user)->get(route('transactions.index', ['search' => 'listrik']));

    $response->assertOk();
    $response->assertSee('Bayar listrik');
    $response->assertDontSee('tetangga');
});

test('transaction search reports when nothing matches', function () {
    $user = User::factory()->create();
    createTransaction($user, 'Bayar listrik');

    $response = $this->actingAs($user)->get(route('transactions.index', ['search' => 'tidak-ada']));

    $response->assertOk();
    $response->assertSee('Tidak ada transaksi yang cocok');
    $response->assertSee('Reset');
});

test('transaction search keyword is kept while paginating', function () {
    $user = User::factory()->create();
    $category = Category::create(['user_id' => $user->id, 'name' => 'Belanja', 'type' => 'expense']);

    foreach (range(1, 16) as $index) {
        Transaction::create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'type' => 'expense',
            'amount' => 10000 * $index,
            'date' => now()->format('Y-m-d'),
            'description' => "Belanja harian {$index}",
        ]);
    }

    $response = $this->actingAs($user)->get(route('transactions.index', ['search' => 'belanja']));

    $response->assertOk();
    $response->assertSee('16 transaksi');
    $response->assertSee('search=belanja', false);
});
