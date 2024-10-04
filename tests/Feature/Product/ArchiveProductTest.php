<?php declare(strict_types = 1);

use App\Livewire\Products;
use App\Models\{Product, User};

use Livewire\Livewire;

use function Pest\Laravel\{actingAs, assertSoftDeleted};
use function PHPUnit\Framework\assertTrue;

it('should be able to archive a product', function () {
    $product = Product::factory()->create();
    $user    = User::factory()->create();

    actingAs($user);

    Livewire::test(Products\Archive::class)
        ->set('product', $product)
        ->call('archive');

    assertSoftDeleted('products', [
        'id' => $product->id,
    ]);
});

test('when confirming we should load the product and set modal to true', function () {
    $product = Product::factory()->create();
    $user    = User::factory()->create();

    actingAs($user);

    Livewire::test(Products\Archive::class)
        ->call('confirmAction', $product->id)
        ->assertSet('product.id', $product->id)
        ->assertSet('modal', true);
});

it('should list archived products', function () {
    $product = Product::factory()->deleted()->create();
    $user    = User::factory()->create();

    actingAs($user);

    Livewire::test(Products\Index::class)
        ->set('searchTrash', true)
        ->assertSee($product->name);

    assertTrue($product->trashed());
});

test('not show archived products by default', function () {
    $product = Product::factory()->deleted()->create();
    $user    = User::factory()->create();

    actingAs($user);

    Livewire::test(Products\Index::class)
        ->assertDontSee($product->name);

    assertTrue($product->trashed());
});
