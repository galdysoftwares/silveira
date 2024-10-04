<?php declare(strict_types = 1);

use App\Livewire\Products;
use App\Models\{Category, Product, User};
use Livewire\Livewire;

use function Pest\Laravel\{actingAs, assertDatabaseHas};

beforeEach(function () {
    $user = User::factory()->create();
    actingAs($user);
    $this->product = Product::factory()->create();
});

it('should update a product', function () {
    $category = Category::factory()->create();

    Livewire::test(Products\Update::class)
        ->call('load', $this->product->id)
        ->set('form.category_id', $category->id)
        ->set('form.title', 'John Doe')
        ->assertPropertyWired('form.title')
        ->set('form.code', '123456')
        ->assertPropertyWired('form.code')
        ->set('form.amount', '125.00')
        ->assertPropertyWired('form.amount')
        ->call('save')
        ->assertHasNoErrors();

    assertDatabaseHas('products', [
        'category_id' => $category->id,
        'title'       => 'John Doe',
        'code'        => '123456',
        'amount'      => '12500',
    ]);
});

describe('validations', function () {
    test('category_id', function ($rule, $value) {
        Livewire::test(Products\Update::class)
            ->set('form.category_id', $value)
            ->call('save')
            ->assertHasErrors(['form.category_id' => $rule]);
    })->with([
        'required' => ['required', ''],
        'exists'   => ['exists', 999],
    ]);

    test('title', function ($rule, $value) {
        Livewire::test(Products\Update::class)
            ->set('form.title', $value)
            ->call('save')
            ->assertHasErrors(['form.title' => $rule]);
    })->with([
        'required' => ['required', ''],
        'min'      => ['min', 'Jo'],
        'max'      => ['max', str_repeat('a', 256)],
    ]);

    test('code', function ($rule, $value) {
        Livewire::test(Products\Update::class)
            ->set('form.title', 'John Doe')
            ->set('form.code', $value)
            ->call('save')
            ->assertHasErrors(['form.code' => $rule]);
    })->with([
        'required' => ['required', ''],
        'max'      => ['max', str_repeat('a', 256)],
    ]);

    test('amount', function ($rule, $value) {
        Livewire::test(Products\Update::class)
            ->set('form.title', 'John Doe')
            ->set('form.code', 'open')
            ->set('form.amount', $value)
            ->call('save')
            ->assertHasErrors(['form.amount' => $rule]);
    })->with([
        'required' => ['required', ''],
    ]);
});
