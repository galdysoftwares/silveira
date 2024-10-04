<?php declare(strict_types = 1);

use App\Livewire\Customers\Show;
use App\Models\{Customer, User};

use Livewire\Livewire;

use function Pest\Laravel\{actingAs, get};

beforeEach(function () {
    $user = User::factory()->create();
    actingAs($user);
});

it('should be able toa access customer.show route', function () {
    $customer = Customer::factory()->create();

    get(route('customers.show', $customer))->assertOk();
});

it('should all the customer information in the page', function () {
    $customer = Customer::factory()->create();

    Livewire::test(Show::class, ['customer' => $customer])
        ->assertSee($customer->name)
        ->assertSee($customer->email)
        ->assertSee($customer->phone)
        ->assertSee($customer->linkedin)
        ->assertSee($customer->facebook)
        ->assertSee($customer->instagram)
        ->assertSee($customer->twitter)
        ->assertSee($customer->address)
        ->assertSee($customer->city)
        ->assertSee($customer->state)
        ->assertSee($customer->zip)
        ->assertSee($customer->age)
        ->assertSee($customer->gender)
        ->assertSee($customer->company)
        ->assertSee($customer->position)
        ->assertSee($customer->created_at->diffForHumans());

});
