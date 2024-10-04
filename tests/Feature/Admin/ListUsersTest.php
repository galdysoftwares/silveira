<?php declare(strict_types = 1);

use App\Enums\Can;
use App\Livewire\Admin\Users\Index;
use App\Models\{Permission, User};
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;

it('should be able to access route admin/users', function () {
    $user = User::factory()->admin()->create();

    actingAs($user)
        ->get(route('admin.users'))
        ->assertOk();
});

it('make sure  the route is protected by the permission BE_AN_ADMIN', function () {
    actingAs(User::factory()->create())
        ->get(route('admin.users'))
        ->assertForbidden();
});

it('should list all users in the page', function () {
    $users = User::factory()->count(10)->create();
    $user  = User::factory()->admin()->create();

    actingAs($user);

    $lw = Livewire::test(Index::class);
    $lw->assertSet('items', function ($items) {
        expect($items)
            ->toBeInstanceOf(LengthAwarePaginator::class)
            ->toHaveCount(10);

        return true;
    });

    foreach ($users as $user) {
        $lw->assertSee($user->name);
    }
});

it('should be able to filter by name and email', function () {
    $admin = User::factory()->admin()->create(['name' => 'Joe Doe', 'email' => 'admin@silveira.com']);
    $mario = User::factory()->create(['name' => 'Mario Silva', 'email' => 'little_guy@gmail.com']);

    actingAs($admin);

    $lw = Livewire::test(Index::class);
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

it('should be able to filter permission.key', function () {
    $admin      = User::factory()->admin()->create(['name' => 'Joe Doe', 'email' => 'admin@silveira.com']);
    $mario      = User::factory()->create(['name' => 'Mario Silva', 'email' => 'little_guy@gmail.com']);
    $permission = Permission::where('key', '=', Can::BE_AN_ADMIN->value)->first();

    actingAs($admin);

    $lw = Livewire::test(Index::class);
    $lw->assertSet('items', function ($items) {
        expect($items)
            ->toBeInstanceOf(LengthAwarePaginator::class)
            ->toHaveCount(2);

        return true;
    })
    ->set('search_permissions', [$permission->id])
    ->assertSet('items', function ($items) {
        expect($items)
            ->toHaveCount(1)
            ->first()->name->toBe('Joe Doe');

        return true;
    });
});

it('shoul be able to list deleted users', function () {
    $admin        = User::factory()->admin()->create(['name' => 'Joe Doe', 'email' => 'admin@gmail.com']);
    $deletedUsers = User::factory()->count(2)->create(['deleted_at' => now()]);

    actingAs($admin);
    Livewire::test(Index::class)
        ->assertSet('items', function ($items) {
            expect($items)->toHaveCount(1);

            return true;
        })
        ->set('search_trash', true)
        ->assertSet('items', function ($items) {
            expect($items)
                ->toHaveCount(2);

            return true;
        });
});

it('should be able to sort by name', function () {
    $admin = User::factory()->admin()->create(['name' => 'Joe Doe', 'email' => 'admin@gmail.com']);
    $users = User::factory()->create(['name' => 'Mario', 'email' => 'little_guy@gmail.com']);

    actingAs($admin);
    Livewire::test(Index::class)
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
    $admin = User::factory()->admin()->create(['name' => 'Joe Doe', 'email' => 'admin@gmail.com']);
    User::factory()->count(30)->create();

    actingAs($admin);
    Livewire::test(Index::class)
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
