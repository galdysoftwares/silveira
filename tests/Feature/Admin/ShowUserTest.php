<?php declare(strict_types = 1);

use App\Livewire\Admin\Users\{Index, Show};
use App\Models\User;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;

it('it should be able to show all details of the user in the component', function () {
    $admin = User::factory()->admin()->create();
    $user  = User::factory()->deleted()->create();

    actingAs($admin);

    Livewire::test(Show::class)
        ->call('loadUser', $user->id)
        ->assertSet('user.id', $user->id) // tip: sometimes the object has different values..
        ->assertSet('modal', true)
        ->assertSee($user->name)
        ->assertSee($user->email)
        ->assertSee($user->created_at->format('d/m/Y H:i'))
        ->assertSee($user->updated_at->format('d/m/Y H:i'))
        ->assertSee($user->deleted_at->format('d/m/Y H:i'))
        ->assertSee($user->deletedBy->name);
});

it('should open modal when loadUser is called', function () {
    $admin = User::factory()->admin()->create();
    $user  = User::factory()->deleted()->create();

    actingAs($admin);

    Livewire::test(Index::class)
        ->call('showUser', $user->id)
        ->assertDispatched('user::show', id: $user->id);
});

test('making sure that the method loadUser has the attribute On', function () {
    $reflection = new ReflectionClass(Show::class);
    $attributes = $reflection->getMethod('loadUser')->getAttributes();

    expect($attributes)->toHaveCount(1);
    /** @var ReflectionAttribute $attribute */
    $attribute = $attributes[0];

    expect($attribute->getName())->toBe('Livewire\Attributes\On')
        ->and($attribute->getArguments())->toHaveCount(1)
        ->and($attribute->getArguments()[0])->toBe('user::show');
});
