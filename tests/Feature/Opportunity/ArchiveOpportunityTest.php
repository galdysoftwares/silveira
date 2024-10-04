<?php declare(strict_types = 1);

use App\Livewire\Opportunities;
use App\Models\{Opportunity, User};

use Livewire\Livewire;

use function Pest\Laravel\{actingAs, assertSoftDeleted};
use function PHPUnit\Framework\assertTrue;

it('should be able to archive a opportunity', function () {
    $opportunity = Opportunity::factory()->create();
    $user        = User::factory()->create();

    actingAs($user);

    Livewire::test(Opportunities\Archive::class)
        ->set('opportunity', $opportunity)
        ->call('archive');

    assertSoftDeleted('opportunities', [
        'id' => $opportunity->id,
    ]);
});

test('when confirming we should load the opportunity and set modal to true', function () {
    $opportunity = Opportunity::factory()->create();
    $user        = User::factory()->create();

    actingAs($user);

    Livewire::test(Opportunities\Archive::class)
        ->call('confirmAction', $opportunity->id)
        ->assertSet('opportunity.id', $opportunity->id)
        ->assertSet('modal', true);
});

it('should list archived Opportunities', function () {
    $opportunity = Opportunity::factory()->deleted()->create();
    $user        = User::factory()->create();

    actingAs($user);

    Livewire::test(Opportunities\Index::class)
        ->set('searchTrash', true)
        ->assertSee($opportunity->name);

    assertTrue($opportunity->trashed());
});

test('not show archived Opportunities by default', function () {
    $opportunity = Opportunity::factory()->deleted()->create();
    $user        = User::factory()->create();

    actingAs($user);

    Livewire::test(Opportunities\Index::class)
        ->assertDontSee($opportunity->name);

    assertTrue($opportunity->trashed());
});
