<?php declare(strict_types = 1);

use App\Livewire\Customers;
use App\Models\{Customer, User};

use Livewire\Livewire;

use function Pest\Laravel\{actingAs, assertSoftDeleted};

it('should be able to archive a customer', function () {
    $customer = Customer::factory()->create();
    $user     = User::factory()->create();

    actingAs($user);

    Livewire::test(Customers\Archive::class)
        ->set('customer', $customer)
        ->call('archive');

    assertSoftDeleted('customers', [
        'id' => $customer->id,
    ]);
});

test('when confirming we should load the customer and set modal to true', function () {
    $customer = Customer::factory()->create();
    $user     = User::factory()->create();

    actingAs($user);

    Livewire::test(Customers\Archive::class)
        ->call('confirmAction', $customer->id)
        ->assertSet('customer.id', $customer->id)
        ->assertSet('modal', true);
});

it('should list archived customers', function () {
    $customer = Customer::factory()->deleted()->create();
    $user     = User::factory()->create();

    actingAs($user);

    Livewire::test(Customers\Index::class)
        ->set('searchTrash', true)
        ->assertSee($customer->name);
});

test('not show archived customers by default', function () {
    $customer = Customer::factory()->deleted()->create();
    $user     = User::factory()->create();

    actingAs($user);

    Livewire::test(Customers\Index::class)
        ->assertDontSee($customer->name);
});
