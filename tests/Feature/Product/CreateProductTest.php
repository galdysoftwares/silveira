<?php declare(strict_types = 1);

use App\Livewire\Products;
use App\Models\{Category, User};
use Livewire\Livewire;

use function Pest\Laravel\{actingAs, assertDatabaseHas};

beforeEach(function () {
    $user = User::factory()->create();
    actingAs($user);
});

it('should create a product', function () {
    $category = Category::factory()->create();

    Livewire::test(Products\Create::class)
        ->set('form.category_id', $category->id)
        ->set('form.title', 'John Doe')
        ->assertPropertyWired('form.title')
        ->set('form.code', '123456')
        ->assertPropertyWired('form.code')
        ->set('form.amount', '125.00')
        ->assertPropertyWired('form.amount')
        ->set('form.description', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.')
        ->call('save')
        ->assertHasNoErrors();

    assertDatabaseHas('products', [
        'category_id' => $category->id,
        'title'       => 'John Doe',
        'code'        => '123456',
        'amount'      => '12500',
        'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
    ]);
});

describe('validations', function () {
    test('category_id', function ($rule, $value) {
        Livewire::test(Products\Create::class)
            ->set('form.category_id', $value)
            ->call('save')
            ->assertHasErrors(['form.category_id' => $rule]);
    })->with([
        'required' => ['required', ''],
        'exists'   => ['exists', 999],
    ]);

    test('title', function ($rule, $value) {
        Livewire::test(Products\Create::class)
            ->set('form.title', $value)
            ->call('save')
            ->assertHasErrors(['form.title' => $rule]);
    })->with([
        'required' => ['required', ''],
        'min'      => ['min', 'Jo'],
        'max'      => ['max', str_repeat('a', 256)],
    ]);

    test('code', function ($rule, $value) {
        if ($rule === 'unique') {
            $category = Category::factory()->create();
            $product  = $category->products()->create([
                'title'  => 'John Doe',
                'code'   => 'open',
                'amount' => 12500,
            ]);

            Livewire::test(Products\Create::class)
                ->set('form.title', 'John Doe')
                ->set('form.code', $product->code)
                ->call('save')
                ->assertHasErrors(['form.code' => $rule]);

            return;
        }

        Livewire::test(Products\Create::class)
            ->set('form.title', 'John Doe')
            ->set('form.code', $value)
            ->call('save')
            ->assertHasErrors(['form.code' => $rule]);
    })->with([
        'required' => ['required', ''],
        'max'      => ['max', str_repeat('a', 256)],
        'unique'   => ['unique', 'open'],
    ]);

    test('amount', function ($rule, $value) {
        Livewire::test(Products\Create::class)
            ->set('form.title', 'John Doe')
            ->set('form.code', 'open')
            ->set('form.amount', $value)
            ->call('save')
            ->assertHasErrors(['form.amount' => $rule]);
    })->with([
        'required' => ['required', ''],
    ]);

});
