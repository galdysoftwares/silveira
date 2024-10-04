<?php declare(strict_types = 1);

use App\Livewire\Customers;
use App\Models\{Customer, User};
use Livewire\Livewire;

use function Pest\Laravel\{actingAs, assertDatabaseHas};

beforeEach(function () {
    actingAs(User::factory()->create());

    $this->customer = Customer::factory()->create();
});

it('should be able to update a customer', function () {
    Livewire::test(Customers\Update::class)
        ->call('load', $this->customer->id)
        ->set('form.name', 'John Doe')
        ->set('form.email', 'john@doe.com')
        ->set('form.phone', '1234567890')
        ->call('save')
        ->assertHasNoErrors();

    assertDatabaseHas('customers', [
        'id'    => $this->customer->id,
        'name'  => 'John Doe',
        'email' => 'john@doe.com',
        'phone' => '1234567890',
        'type'  => 'customer',
    ]);
});

it('should require a name', function () {
    Livewire::test(Customers\Update::class)
        ->call('load', $this->customer->id)
        ->set('form.name', '')
        ->set('form.email', 'john@doe.com')
        ->set('form.phone', '1234567890')
        ->call('save')
        ->assertHasErrors(['form.name' => 'required']);

    assertDatabaseHas('customers', [
        'id'    => $this->customer->id,
        'name'  => $this->customer->name,
        'email' => $this->customer->email,
        'phone' => $this->customer->phone,
        'type'  => $this->customer->type,
    ]);
});

it('should require an email or phone', function () {
    Livewire::test(Customers\Update::class)
        ->call('load', $this->customer->id)
        ->set('form.name', 'John Doe')
        ->set('form.email', '')
        ->set('form.phone', '')
        ->call('save')
        ->assertHasErrors();
});

it('should require a valid email', function () {
    Livewire::test(Customers\Update::class)
        ->call('load', $this->customer->id)
        ->set('form.name', 'John Doe')
        ->set('form.email', 'invalid-email')
        ->set('form.phone', '')
        ->call('save')
        ->assertHasErrors(['form.email' => 'email']);
});

it('should require a unique email', function () {
    Livewire::test(Customers\Create::class)
    ->set('form.name', 'John Doe')
    ->set('form.email', 'john@doe.com')
    ->set('form.phone', '1234567890')
    ->call('save')
    ->assertHasNoErrors();

    Livewire::test(Customers\Update::class)
    ->call('load', $this->customer->id)
    ->set('form.name', 'John Doe')
    ->set('form.email', 'john@doe.com')
    ->set('form.phone', '1234567870')
    ->call('save')
    ->assertHasErrors(['form.email' => 'unique']);
});

it('should require a unique phone', function () {
    Livewire::test(Customers\Create::class)
    ->set('form.name', 'John Doe')
    ->set('form.email', 'john@doe.com')
    ->set('form.phone', '1234567890')
    ->call('save')
    ->assertHasNoErrors();

    Livewire::test(Customers\Update::class)
    ->call('load', $this->customer->id)
    ->set('form.name', 'Any Doe')
    ->set('form.email', 'any@doe.com')
    ->set('form.phone', '1234567890')
    ->call('save')
    ->assertHasErrors(['form.phone' => 'unique']);
});

it('should be able to update a customer without a phone', function () {
    Livewire::test(Customers\Update::class)
        ->call('load', $this->customer->id)
        ->set('form.name', 'John Doe')
        ->set('form.email', 'john@doe.com')
        ->set('form.phone', '')
        ->call('save')
        ->assertHasNoErrors();

    Livewire::test(Customers\Update::class)
    ->call('load', $this->customer->id)
    ->set('form.name', 'John Doe Updated')
    ->set('form.email', $this->customer->email)
    ->set('form.phone', '')
    ->call('save')
    ->assertHasNoErrors();

});

it('should be able to update a customer without an email', function () {
    Livewire::test(Customers\Update::class)
        ->call('load', $this->customer->id)
        ->set('form.name', 'John Doe')
        ->set('form.email', '')
        ->set('form.phone', '1234567890')
        ->call('save')
        ->assertHasNoErrors();

    Livewire::test(Customers\Update::class)
        ->call('load', $this->customer->id)
        ->set('form.name', 'John Doe')
        ->set('form.email', '')
        ->set('form.phone', $this->customer->phone)
        ->call('save')
        ->assertHasNoErrors();
});

todo('should require a valid phone', function () {});
