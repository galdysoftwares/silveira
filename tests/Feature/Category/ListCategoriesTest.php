<?php declare(strict_types = 1);

use App\Livewire\Categories;
use App\Models\{Category, User};
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;

it('should be able to access route categories', function () {
    $user = User::factory()->admin()->create();

    actingAs($user)
        ->get(route('admin.categories'))
        ->assertOk();
});

it('should list all categories in the page', function () {
    $user       = User::factory()->admin()->create();
    $categories = Category::factory()->count(10)->create();

    actingAs($user);

    $lw = Livewire::test(Categories\Index::class);
    $lw->assertSet('items', function ($items) {
        expect($items)
            ->toBeInstanceOf(LengthAwarePaginator::class)
            ->toHaveCount(10);

        return true;
    });

    foreach ($categories as $category) {
        $lw->assertSee($category->title);
    }
});

it('should be able to filter by title', function () {
    $user  = User::factory()->admin()->create(['name' => 'John Doe']);
    $mario = Category::factory()->create(['title' => 'Joe Doe']);
    $joe   = Category::factory()->create(['title' => 'Mario']);

    actingAs($user);

    $lw = Livewire::test(Categories\Index::class);
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

it('should be able to list deleted categories', function () {
    $admin             = User::factory()->admin()->admin()->create(['name' => 'Joe Doe']);
    $deletedcategories = Category::factory()->count(2)->create(['deleted_at' => now()]);
    $category          = Category::factory()->count(4)->create();

    actingAs($admin);
    Livewire::test(Categories\Index::class)
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
    $user = User::factory()->admin()->admin()->create();

    actingAs($user);
    Livewire::test(Categories\Index::class)
        ->assertSet('headers', [
            ['key' => 'id', 'label' => '#', 'sortColumnBy' => 'id', 'sortDirection' => 'asc'],
            ['key' => 'title', 'label' => __('Title'), 'sortColumnBy' => 'id', 'sortDirection' => 'asc'],
        ]);
});

it('should be able to sort by title', function () {
    $user  = User::factory()->admin()->create(['name' => 'Joe Doe']);
    $mario = Category::factory()->create(['title' => 'Mario']);
    $joe   = Category::factory()->create(['title' => 'Joe Doe']);

    actingAs($user);
    Livewire::test(Categories\Index::class)
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
    $user = User::factory()->admin()->create(['name' => 'Joe Doe']);
    Category::factory()->count(30)->create();

    actingAs($user);
    Livewire::test(Categories\Index::class)
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
