<?php declare(strict_types = 1);

use App\Livewire\Opportunities;
use App\Models\{Customer, User};
use Livewire\Livewire;

use function Pest\Laravel\{actingAs, assertDatabaseHas};

beforeEach(function () {
    $user = User::factory()->create();
    actingAs($user);
});

it('should create a opportunity', function () {
    $customer = Customer::factory()->create();

    Livewire::test(Opportunities\Create::class)
        ->set('form.customer_id', $customer->id)
        ->set('form.title', 'John Doe')
        ->assertPropertyWired('form.title')
        ->set('form.status', 'open')
        ->assertPropertyWired('form.status')
        ->set('form.amount', '125.00')
        ->assertPropertyWired('form.amount')
        ->call('save')
        ->assertHasNoErrors();

    assertDatabaseHas('opportunities', [
        'customer_id' => $customer->id,
        'title'       => 'John Doe',
        'status'      => 'open',
        'amount'      => '12500',
    ]);
});

describe('validations', function () {
    test('customer_id', function ($rule, $value) {
        Livewire::test(Opportunities\Create::class)
            ->set('form.customer_id', $value)
            ->call('save')
            ->assertHasErrors(['form.customer_id' => $rule]);
    })->with([
        'required' => ['required', ''],
        'exists'   => ['exists', 999],
    ]);

    test('title', function ($rule, $value) {
        Livewire::test(Opportunities\Create::class)
            ->set('form.title', $value)
            ->call('save')
            ->assertHasErrors(['form.title' => $rule]);
    })->with([
        'required' => ['required', ''],
        'min'      => ['min', 'Jo'],
        'max'      => ['max', str_repeat('a', 256)],
    ]);

    test('status', function ($rule, $value) {
        Livewire::test(Opportunities\Create::class)
            ->set('form.title', 'John Doe')
            ->set('form.status', $value)
            ->call('save')
            ->assertHasErrors(['form.status' => $rule]);
    })->with([
        'required' => ['required', ''],
        'in'       => ['in', 'invalid'],
    ]);

    test('amount', function ($rule, $value) {
        Livewire::test(Opportunities\Create::class)
            ->set('form.title', 'John Doe')
            ->set('form.status', 'open')
            ->set('form.amount', $value)
            ->call('save')
            ->assertHasErrors(['form.amount' => $rule]);
    })->with([
        'required' => ['required', ''],
    ]);
});
