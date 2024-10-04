<?php declare(strict_types = 1);

use App\Livewire\Opportunities;
use App\Models\{Customer, User, opportunity};
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;

it('should be able to access route opportunities', function () {
    $user = User::factory()->create();

    actingAs($user)
        ->get(route('opportunities'))
        ->assertOk();
});

it('should list all opportunities in the page', function () {
    $user          = User::factory()->create();
    $opportunities = Opportunity::factory()->count(10)->create();

    actingAs($user);

    $lw = Livewire::test(Opportunities\Index::class);
    $lw->assertSet('items', function ($items) {
        expect($items)
            ->toBeInstanceOf(LengthAwarePaginator::class)
            ->toHaveCount(10);

        return true;
    });

    foreach ($opportunities as $opportunity) {
        $lw->assertSee($opportunity->title);
    }
});

it('should be able to filter by title', function () {
    $user     = User::factory()->create(['name' => 'John Doe']);
    $customer = Customer::factory()->create(['name' => 'Zack']);
    $mario    = Opportunity::factory()->create(['title' => 'Joe Doe', 'customer_id' => $customer->id]);
    $joe      = Opportunity::factory()->create(['title' => 'Mario', 'customer_id' => $customer->id]);

    actingAs($user);

    $lw = Livewire::test(Opportunities\Index::class);
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
            ->first()->title->toBe('Mario');

        return true;
    });
});

it('should be able to list deleted opportunities', function () {
    $admin                = User::factory()->admin()->create(['name' => 'Joe Doe']);
    $deletedopportunities = Opportunity::factory()->count(2)->create(['deleted_at' => now()]);
    $opportunity          = Opportunity::factory()->count(4)->create();

    actingAs($admin);
    Livewire::test(Opportunities\Index::class)
        ->assertSet('items', function ($items) {
            expect($items)
                ->toHaveCount(4);

            return true;
        })
        ->set('searchTrash', true)
        ->assertSet('items', function ($items) {
            expect($items)
                ->toHaveCount(2);

            return true;
        });
});

test('check the table format', function () {
    $user = User::factory()->admin()->create();

    actingAs($user);
    Livewire::test(Opportunities\Index::class)
        ->assertSet('headers', [
            ['key' => 'id', 'label' => '#', 'sortColumnBy' => 'id', 'sortDirection' => 'asc'],
            ['key' => 'title', 'label' => __('Title'), 'sortColumnBy' => 'id', 'sortDirection' => 'asc'],
            ['key' => 'customer_name', 'label' => __('Customer'), 'sortColumnBy' => 'id', 'sortDirection' => 'asc'],
            ['key' => 'status', 'label' => __('Status'), 'sortColumnBy' => 'id', 'sortDirection' => 'asc'],
            ['key' => 'amount', 'label' => __('Amount'), 'sortColumnBy' => 'id', 'sortDirection' => 'asc'],
        ]);
});

it('should be able to sort by title', function () {
    $user  = User::factory()->create(['name' => 'Joe Doe']);
    $mario = Opportunity::factory()->create(['title' => 'Mario']);
    $joe   = Opportunity::factory()->create(['title' => 'Joe Doe']);

    actingAs($user);
    Livewire::test(Opportunities\Index::class)
        ->set('sortDirection', 'asc')
        ->set('sortColumnBy', 'title')
        ->assertSet('items', function ($items) {
            expect($items)
                ->first()->title->toBe('Joe Doe')
                ->and($items)->last()->title->toBe('Mario');

            return true;
        })
        ->set('sortDirection', 'desc')
        ->set('sortColumnBy', 'title')
        ->assertSet('items', function ($items) {
            expect($items)
                ->first()->title->toBe('Mario')
                ->and($items)->last()->title->toBe('Joe Doe');

            return true;
        });
});

it('should be able to paginate the result', function () {
    $user = User::factory()->create(['name' => 'Joe Doe']);
    Opportunity::factory()->count(30)->create();

    actingAs($user);
    Livewire::test(Opportunities\Index::class)
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
