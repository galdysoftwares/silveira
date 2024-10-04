<?php declare(strict_types = 1);

use App\Livewire\Categories;
use App\Models\{Category, User};

use Livewire\Livewire;

use function Pest\Laravel\{actingAs, assertDatabaseHas};

it('should be able to restore a category', function () {
    $category = Category::factory()->create();
    $user     = User::factory()->create();

    actingAs($user);

    Livewire::test(Categories\Restore::class)
        ->set('category', $category)
        ->call('restore');

    $this->assertDatabaseHas('categories', [
        'id'         => $category->id,
        'deleted_at' => null,
    ]);
});

test('when confirming we should load the category and set modal to true', function () {
    $category = Category::factory()->deleted()->create();
    $user     = User::factory()->create();

    actingAs($user);

    Livewire::test(Categories\Restore::class)
        ->call('confirmAction', $category->id)
        ->assertSet('category.id', $category->id)
        ->assertSet('modal', true);
});

it('should be able to restore a category from the archive', function () {
    $category = Category::factory()->deleted()->create();
    $user     = User::factory()->create();

    actingAs($user);

    $category->delete();

    Livewire::test(Categories\Restore::class)
        ->set('category', $category)
        ->call('restore');

    assertDatabaseHas('categories', [
        'id'         => $category->id,
        'deleted_at' => null,
    ]);
});

test('make sure restore method is wired', function () {
    Livewire::test(Categories\Restore::class)
        ->assertMethodWired('restore');
});
