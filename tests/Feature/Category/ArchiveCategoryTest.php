<?php declare(strict_types = 1);

use App\Livewire\Categories;
use App\Models\{Category, User};

use Livewire\Livewire;

use function Pest\Laravel\{actingAs, assertSoftDeleted};
use function PHPUnit\Framework\assertTrue;

it('should be able to archive a category', function () {
    $category = Category::factory()->create();
    $user     = User::factory()->admin()->create();

    actingAs($user);

    Livewire::test(Categories\Archive::class)
        ->set('category', $category)
        ->call('archive');

    assertSoftDeleted('categories', [
        'id' => $category->id,
    ]);
});

test('when confirming we should load the category and set modal to true', function () {
    $category = Category::factory()->create();
    $user     = User::factory()->admin()->create();

    actingAs($user);

    Livewire::test(Categories\Archive::class)
        ->call('confirmAction', $category->id)
        ->assertSet('category.id', $category->id)
        ->assertSet('modal', true);
});

it('should list archived categories', function () {
    $category = Category::factory()->deleted()->create();
    $user     = User::factory()->admin()->create();

    actingAs($user);

    Livewire::test(Categories\Index::class)
        ->set('searchTrash', true)
        ->assertSee($category->title);

    assertTrue($category->trashed());
});

test('not show archived dcategories by default', function () {
    $category = Category::factory()->deleted()->create();
    $user     = User::factory()->admin()->create();

    actingAs($user);

    Livewire::test(Categories\Index::class)
        ->assertDontSee($category->title);

    assertTrue($category->trashed());
});
