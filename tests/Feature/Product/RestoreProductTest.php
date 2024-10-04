<?php declare(strict_types = 1);

use App\Livewire\Products;
use App\Models\{Product, User};

use Livewire\Livewire;

use function Pest\Laravel\{actingAs, assertDatabaseHas};

it('should be able to restore a product', function () {
    $product = Product::factory()->create();
    $user    = User::factory()->create();

    actingAs($user);

    Livewire::test(Products\Restore::class)
        ->set('product', $product)
        ->call('restore');

    $this->assertDatabaseHas('products', [
        'id'         => $product->id,
        'deleted_at' => null,
    ]);
});

test('when confirming we should load the product and set modal to true', function () {
    $product = Product::factory()->deleted()->create();
    $user    = User::factory()->create();

    actingAs($user);

    Livewire::test(Products\Restore::class)
        ->call('confirmAction', $product->id)
        ->assertSet('product.id', $product->id)
        ->assertSet('modal', true);
});

it('should be able to restore a product from the archive', function () {
    $product = Product::factory()->deleted()->create();
    $user    = User::factory()->create();

    actingAs($user);

    $product->delete();

    Livewire::test(Products\Restore::class)
        ->set('product', $product)
        ->call('restore');

    assertDatabaseHas('products', [
        'id'         => $product->id,
        'deleted_at' => null,
    ]);
});

test('make sure restore method is wired', function () {
    Livewire::test(Products\Restore::class)
        ->assertMethodWired('restore');
});
