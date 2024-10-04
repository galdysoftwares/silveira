<?php declare(strict_types = 1);

use App\Livewire\Categories;
use App\Models\{Category, User};
use Livewire\Livewire;

use function Pest\Laravel\{actingAs, assertDatabaseHas};

beforeEach(function () {
    actingAs(User::factory()->create());

    $this->category = Category::factory()->create();
});

it('should be able to update a category', function () {
    Livewire::test(Categories\Update::class)
        ->call('load', $this->category->id)
        ->set('form.title', 'John Doe')
        ->call('save')
        ->assertHasNoErrors();

    assertDatabaseHas('categories', [
        'id'    => $this->category->id,
        'title' => 'John Doe',
    ]);
});

it('should require a title', function () {
    Livewire::test(Categories\Update::class)
        ->call('load', $this->category->id)
        ->set('form.title', '')
        ->call('save')
        ->assertHasErrors(['form.title' => 'required']);

    assertDatabaseHas('categories', [
        'id'    => $this->category->id,
        'title' => $this->category->title,
    ]);
});
