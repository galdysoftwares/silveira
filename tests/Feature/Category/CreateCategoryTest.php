<?php declare(strict_types = 1);

use App\Livewire\Categories;
use App\Models\{User};
use Livewire\Livewire;

use function Pest\Laravel\{actingAs, assertDatabaseHas};

beforeEach(function () {
    $user = User::factory()->create();
    actingAs($user);
});

it('should create a category', function () {

    Livewire::test(Categories\Create::class)
        ->set('form.title', 'John Doe')
        ->assertPropertyWired('form.title')
        ->call('save')
        ->assertHasNoErrors();

    assertDatabaseHas('categories', [
        'title' => 'John Doe',
    ]);
});

describe('validations', function () {
    test('title', function ($rule, $value) {
        Livewire::test(Categories\Create::class)
            ->set('form.title', $value)
            ->call('save')
            ->assertHasErrors(['form.title' => $rule]);
    })->with([
        'required' => ['required', ''],
        'min'      => ['min', 'Jo'],
        'max'      => ['max', str_repeat('a', 256)],
    ]);
});
