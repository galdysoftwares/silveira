<?php declare(strict_types = 1);

use App\Livewire\Products;
use App\Models\{Customer, Product, User};
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;

it('should be able to access route products', function () {
    $user = User::factory()->create();

    actingAs($user)
        ->get(route('products'))
        ->assertOk();
});

it('should list all products in the page', function () {
    $user     = User::factory()->create();
    $products = Product::factory()->count(10)->create();

    actingAs($user);

    $lw = Livewire::test(Products\Index::class);
    $lw->assertSet('items', function ($items) {
        expect($items)
            ->toBeInstanceOf(LengthAwarePaginator::class)
            ->toHaveCount(10);

        return true;
    });

    foreach ($products as $product) {
        $lw->assertSee($product->title);
    }
});

it('should be able to filter by title', function () {
    $user     = User::factory()->create(['name' => 'John Doe']);
    $customer = Customer::factory()->create(['name' => 'Zack']);
    $joe      = Product::factory()->create(['title' => 'Joe Doe']);
    $mario    = Product::factory()->create(['title' => 'Mario']);

    actingAs($user);

    $lw = Livewire::test(Products\Index::class);
    $lw->assertSet('items', function ($items) {
        expect($items)
            ->toBeInstanceOf(LengthAwarePaginator::class)
            ->toHaveCount(2);

        return true;
    })
    ->set('search', 'Mario')
    ->assertSet('items', function ($items) {
        expect($items)
            ->toHaveCount(1)
            ->first()->title->toBe('Mario');

        return true;
    });
});

it('should be able to list deleted products', function () {
    $admin           = User::factory()->admin()->create(['name' => 'Joe Doe']);
    $deletedproducts = Product::factory()->count(2)->create(['deleted_at' => now()]);
    $product         = Product::factory()->count(4)->create();

    actingAs($admin);
    Livewire::test(Products\Index::class)
        ->assertSet('items', function ($items) {
            expect($items)
                ->toHaveCount(4);

            return true;
        })
        ->set('searchTrash', true)
        ->assertSet('items', function ($items) {
            expect($items)
                ->toHaveCount(2);

            return true;
        });
});

test('check the table format', function () {
    $user = User::factory()->admin()->create();

    actingAs($user);
    Livewire::test(Products\Index::class)
        ->assertSet('headers', [
            ['key' => 'id', 'label' => '#', 'sortColumnBy' => 'id', 'sortDirection' => 'asc'],
            ['key' => 'title', 'label' => __('Title'), 'sortColumnBy' => 'id', 'sortDirection' => 'asc'],
            ['key' => 'code', 'label' => __('Code'), 'sortColumnBy' => 'id', 'sortDirection' => 'asc'],
            ['key' => 'category_name', 'label' => __('Category'), 'sortColumnBy' => 'id', 'sortDirection' => 'asc'],
            ['key' => 'amount', 'label' => __('Amount'), 'sortColumnBy' => 'id', 'sortDirection' => 'asc'],
        ]);
});

it('should be able to sort by title', function () {
    $user  = User::factory()->create(['name' => 'Joe Doe']);
    $mario = Product::factory()->create(['title' => 'Mario']);
    $joe   = Product::factory()->create(['title' => 'Joe Doe']);

    actingAs($user);
    Livewire::test(Products\Index::class)
        ->set('sortDirection', 'asc')
        ->set('sortColumnBy', 'title')
        ->assertSet('items', function ($items) {
            expect($items)
                ->first()->title->toBe('Joe Doe')
                ->and($items)->last()->title->toBe('Mario');

            return true;
        })
        ->set('sortDirection', 'desc')
        ->set('sortColumnBy', 'title')
        ->assertSet('items', function ($items) {
            expect($items)
                ->first()->title->toBe('Mario')
                ->and($items)->last()->title->toBe('Joe Doe');

            return true;
        });
});

it('should be able to paginate the result', function () {
    $user = User::factory()->create(['name' => 'Joe Doe']);
    Product::factory()->count(30)->create();

    actingAs($user);
    Livewire::test(Products\Index::class)
        ->assertSet('items', function (LengthAwarePaginator $items) {
            expect($items)
                ->toHaveCount(10);

            return true;
        })
        ->set('perPage', 20)
        ->assertSet('items', function (LengthAwarePaginator $items) {
            expect($items)
                ->toHaveCount(20);

            return true;
        });
});
