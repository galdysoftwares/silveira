<?php declare(strict_types = 1);

use App\Livewire\Opportunities;
use App\Models\{Opportunity, User};

use Livewire\Livewire;

use function Pest\Laravel\{actingAs, assertDatabaseHas};

it('should be able to restore a opportunity', function () {
    $opportunity = Opportunity::factory()->create();
    $user        = User::factory()->create();

    actingAs($user);

    Livewire::test(Opportunities\Restore::class)
        ->set('opportunity', $opportunity)
        ->call('restore');

    $this->assertDatabaseHas('opportunities', [
        'id'         => $opportunity->id,
        'deleted_at' => null,
    ]);
});

test('when confirming we should load the opportunity and set modal to true', function () {
    $opportunity = Opportunity::factory()->deleted()->create();
    $user        = User::factory()->create();

    actingAs($user);

    Livewire::test(Opportunities\Restore::class)
        ->call('confirmAction', $opportunity->id)
        ->assertSet('opportunity.id', $opportunity->id)
        ->assertSet('modal', true);
});

it('should be able to restore a opportunity from the archive', function () {
    $opportunity = Opportunity::factory()->deleted()->create();
    $user        = User::factory()->create();

    actingAs($user);

    $opportunity->delete();

    Livewire::test(Opportunities\Restore::class)
        ->set('opportunity', $opportunity)
        ->call('restore');

    assertDatabaseHas('opportunities', [
        'id'         => $opportunity->id,
        'deleted_at' => null,
    ]);
});

test('make sure restore method is wired', function () {
    Livewire::test(Opportunities\Restore::class)
        ->assertMethodWired('restore');
});
