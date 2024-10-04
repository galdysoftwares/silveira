<?php declare(strict_types = 1);

use App\Livewire\Customers;
use App\Models\{Customer, User};
use Livewire\Livewire;

use function Pest\Laravel\{actingAs, assertDatabaseCount, assertDatabaseHas};

beforeEach(function () {
    $user = User::factory()->create();
    actingAs($user);
});

it('should create a customer', function () {
    Livewire::test(Customers\Create::class)
        ->set('form.name', 'John Doe')
        ->set('form.email', 'john@doe.com')
        ->set('form.phone', '1234567890')
        ->call('save')
        ->assertHasNoErrors();

    assertDatabaseHas('customers', [
        'type'  => 'customer',
        'name'  => 'John Doe',
        'email' => 'john@doe.com',
        'phone' => '1234567890',
    ]);
});

it('should require a name', function () {
    Livewire::test(Customers\Create::class)
        ->set('form.name', '')
        ->set('form.email', 'john@doe.com')
        ->set('form.phone', '1234567890')
        ->call('save')
        ->assertHasErrors(['form.name' => 'required']);

    assertDatabaseCount('customers', 0);
});

it('should require an email or phone', function () {
    Livewire::test(Customers\Create::class)
        ->set('form.name', 'John Doe')
        ->set('form.email', '')
        ->set('form.phone', '')
        ->call('save')
        ->assertHasErrors();

    assertDatabaseCount('customers', 0);
});

it('should require a valid email', function () {
    Livewire::test(Customers\Create::class)
        ->set('form.name', 'John Doe')
        ->set('form.email', 'invalid-email')
        ->set('form.phone', '')
        ->call('save')
        ->assertHasErrors(['form.email' => 'email']);

    assertDatabaseCount('customers', 0);
});

it('should require a unique email', function () {
    Livewire::test(Customers\Create::class)
    ->set('form.name', 'John Doe')
    ->set('form.email', 'john@doe.com')
    ->set('form.phone', '1234567890')
    ->call('save')
    ->assertHasNoErrors();

    Livewire::test(Customers\Create::class)
    ->set('form.name', 'John Doe')
    ->set('form.email', 'john@doe.com')
    ->set('form.phone', '1234567890')
    ->call('save')
    ->assertHasErrors(['form.email' => 'unique']);

    assertDatabaseCount('customers', 1);
});

it('should require a unique phone', function () {
    Livewire::test(Customers\Create::class)
    ->set('form.name', 'John Doe')
    ->set('form.email', 'john@doe.com')
    ->set('form.phone', '1234567890')
    ->call('save')
    ->assertHasNoErrors();

    Livewire::test(Customers\Create::class)
    ->set('form.name', 'Any Doe')
    ->set('form.email', 'any@doe.com')
    ->set('form.phone', '1234567890')
    ->call('save')
    ->assertHasErrors(['form.phone' => 'unique']);
});

it('should be able to create a customer without a phone', function () {
    Livewire::test(Customers\Create::class)
        ->set('form.name', 'John Doe')
        ->set('form.email', 'john@doe.com')
        ->set('form.phone', '')
        ->call('save')
        ->assertHasNoErrors();
});

todo('should require a valid phone', function () {
    Livewire::test(Customers\Create::class)
        ->set('form.name', 'John Doe')
        ->set('form.email', 'john@doe.com')
        ->set('form.phone', 'invalid-phone')
        ->call('save')
        ->assertHasErrors(['form.phone' => 'phone']);

    assertDatabaseCount('customers', 0);
});

describe('validations', function () {
    test('name', function ($rule, $value) {
        Livewire::test(Customers\Create::class)
            ->set('form.name', $value)
            ->call('save')
            ->assertHasErrors(['form.name' => $rule]);
    })->with([
        'required' => ['required', ''],
        'min'      => ['min', 'Jo'],
        'max'      => ['max', str_repeat('a', 256)],
    ]);

    test('email should be required if we dont have a phone number', function () {
        Livewire::test(Customers\Create::class)
            ->set('form.email', '')
            ->set('form.phone', '')
            ->call('save')
            ->assertHasErrors(['form.email' => 'required_without']);

        Livewire::test(Customers\Create::class)
            ->set('form.email', '')
            ->set('form.phone', '1232132')
            ->call('save')
            ->assertHasNoErrors(['form.email' => 'required_without']);
    });

    test('email should be valid', function () {
        Livewire::test(Customers\Create::class)
            ->set('form.email', 'invalid-email')
            ->call('save')
            ->assertHasErrors(['form.email' => 'email']);

        Livewire::test(Customers\Create::class)
            ->set('form.email', 'joe@doe.com')
            ->call('save')
            ->assertHasNoErrors(['form.email' => 'email']);
    });

    test('email should be unique', function () {
        Customer::factory()->create(['email' => 'joe@doe.com']);

        Livewire::test(Customers\Create::class)
            ->set('form.email', 'joe@doe.com')
            ->call('save')
            ->assertHasErrors(['form.email' => 'unique']);
    });

    test('phone should be required if email is empty', function () {
        Livewire::test(Customers\Create::class)
            ->set('form.email', '')
            ->set('form.phone', '')
            ->call('save')
            ->assertHasErrors(['form.phone' => 'required_without']);

        Livewire::test(Customers\Create::class)
            ->set('form.email', 'joe@doe.com')
            ->set('form.phone', '')
            ->call('save')
            ->assertHasNoErrors(['form.phone' => 'required_without']);
    });

    test('phone should be unique', function () {

        Customer::factory()->create(['phone' => '123456789']);

        Livewire::test(Customers\Create::class)
            ->set('form.phone', '123456789')
            ->call('save')
            ->assertHasErrors(['form.phone' => 'unique']);

    });
});
