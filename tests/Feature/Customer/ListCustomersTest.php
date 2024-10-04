<?php declare(strict_types = 1);

use App\Livewire\Customers;
use App\Models\{Customer, User};
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;

it('should be able to access route customers', function () {
    $user = User::factory()->create();

    actingAs($user)
        ->get(route('customers'))
        ->assertOk();
});

it('should list all customers in the page', function () {
    $user      = User::factory()->create();
    $customers = Customer::factory()->count(10)->create();

    actingAs($user);

    $lw = Livewire::test(Customers\Index::class);
    $lw->assertSet('items', function ($items) {
        expect($items)
            ->toBeInstanceOf(LengthAwarePaginator::class)
            ->toHaveCount(10);

        return true;
    });

    foreach ($customers as $customer) {
        $lw->assertSee($customer->name);
    }
});

it('should be able to filter by name and email', function () {
    $user  = User::factory()->create(['name' => 'Joe Doe', 'email' => 'admin@silveira.com']);
    $mario = Customer::factory()->create(['name' => 'Mario Silva', 'email' => 'little_guy@gmail.com']);
    $joe   = Customer::factory()->create(['name' => 'Joe Doe', 'email' => 'joe@doe.com']);

    actingAs($user);

    $lw = Livewire::test(Customers\Index::class);
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
            ->first()->name->toBe('Mario Silva');

        return true;
    });
});

it('shoul be able to list deleted customers', function () {
    $admin            = User::factory()->admin()->create(['name' => 'Joe Doe', 'email' => 'admin@gmail.com']);
    $deletedcustomers = Customer::factory()->count(2)->create(['deleted_at' => now()]);
    $customer         = Customer::factory()->create();

    actingAs($admin);
    Livewire::test(Customers\Index::class)
        ->assertSet('items', function ($items) {
            expect($items)->toHaveCount(1);

            return true;
        })
        ->set('searchTrash', true)
        ->assertSet('items', function ($items) {
            expect($items)
                ->toHaveCount(2);

            return true;
        });
});

it('should be able to sort by name', function () {
    $user  = User::factory()->create(['name' => 'Joe Doe', 'email' => 'admin@silveira.com']);
    $mario = Customer::factory()->create(['name' => 'Mario', 'email' => 'little_guy@gmail.com']);
    $joe   = Customer::factory()->create(['name' => 'Joe Doe', 'email' => 'Joe@doe.com']);

    actingAs($user);
    Livewire::test(Customers\Index::class)
        ->set('sortDirection', 'asc')
        ->set('sortColumnBy', 'name')
        ->assertSet('items', function ($items) {
            expect($items)
                ->first()->name->toBe('Joe Doe')
                ->and($items)->last()->name->toBe('Mario');

            return true;
        })
        ->set('sortDirection', 'desc')
        ->set('sortColumnBy', 'name')
        ->assertSet('items', function ($items) {
            expect($items)
                ->first()->name->toBe('Mario')
                ->and($items)->last()->name->toBe('Joe Doe');

            return true;
        });
});

it('should be able to paginate the result', function () {
    $user = User::factory()->create(['name' => 'Joe Doe', 'email' => 'admin@gmail.com']);
    Customer::factory()->count(30)->create();

    actingAs($user);
    Livewire::test(Customers\Index::class)
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
