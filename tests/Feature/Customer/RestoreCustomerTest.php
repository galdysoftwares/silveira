<?php declare(strict_types = 1);

use App\Livewire\Customers;
use App\Models\{Customer, User};

use Livewire\Livewire;

use function Pest\Laravel\{actingAs, assertDatabaseHas};

it('should be able to restore a customer', function () {
    $customer = Customer::factory()->create();
    $user     = User::factory()->create();

    actingAs($user);

    Livewire::test(Customers\Restore::class)
        ->set('customer', $customer)
        ->call('restore');

    $this->assertDatabaseHas('customers', [
        'id'         => $customer->id,
        'deleted_at' => null,
    ]);
});

test('when confirming we should load the customer and set modal to true', function () {
    $customer = Customer::factory()->deleted()->create();
    $user     = User::factory()->create();

    actingAs($user);

    Livewire::test(Customers\Restore::class)
        ->call('confirmAction', $customer->id)
        ->assertSet('customer.id', $customer->id)
        ->assertSet('modal', true);
});

it('should be able to restore a customer from the archive', function () {
    $customer = Customer::factory()->deleted()->create();
    $user     = User::factory()->create();

    actingAs($user);

    $customer->delete();

    Livewire::test(Customers\Restore::class)
        ->set('customer', $customer)
        ->call('restore');

    assertDatabaseHas('customers', [
        'id'         => $customer->id,
        'deleted_at' => null,
    ]);
});

test('make sure restore method is wired', function () {
    Livewire::test(Customers\Restore::class)
        ->assertMethodWired('restore');
});
