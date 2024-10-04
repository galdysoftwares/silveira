<?php declare(strict_types = 1);

use App\Enums\Can;
use App\Models\{Permission, User};
use Database\Seeders\PermissionSeeder;
use Illuminate\Support\Facades\{Cache, DB};

use function Pest\Laravel\{actingAs, assertDatabaseHas, seed};

it('should be able to give an user a permission to do something', function () {
    /** @var User $user */
    $user = User::factory()->create();

    $user->givePermissionTo(Can::BE_AN_ADMIN);

    expect($user->hasPermissionTo(Can::BE_AN_ADMIN))->toBeTrue();

    assertDatabaseHas('permissions', [
        'key' => Can::BE_AN_ADMIN,
    ]);

    assertDatabaseHas('permission_user', [
        'user_id'       => $user->id,
        'permission_id' => Permission::where('key', '=', Can::BE_AN_ADMIN)->first()->id,
    ]);
});

test('permission has to have a seeder', function () {
    $this->seed(PermissionSeeder::class);
    assertDatabaseHas('permissions', [
        'key' => Can::BE_AN_ADMIN,
    ]);
});

test('seed with an admin user', function () {
    seed([
        PermissionSeeder::class,
        UsersSeeder::class,
    ]);

    assertDatabaseHas('permissions', [
        'key' => Can::BE_AN_ADMIN,
    ]);

    assertDatabaseHas('permission_user', [
        'user_id'       => User::first()?->id,
        'permission_id' => Permission::where('key', '=', Can::BE_AN_ADMIN)->first()?->id,
    ]);
});

it('should block the access to an admin page if the user does not have the permission', function () {
    seed(PermissionSeeder::class);

    $user = User::factory()->create();

    actingAs($user)
        ->get(route('admin.dashboard'))
        ->assertForbidden();
});

test('make sure that we are using cache to store user permissions', function () {
    $user = User::factory()->create();
    $user->givePermissionTo(Can::BE_AN_ADMIN);
    $cacheKey = 'user:' . $user->id . ':permissions';

    expect(Cache::has($cacheKey))->toBeTrue('Checking if cache key exists')
        ->and(Cache::get($cacheKey))->toBe($user->permissions, 'Checking if cache key has the correct value');
});

test('make sure that we are using the cache the retrieve', function () {
    $user = User::factory()->create();
    $user->givePermissionTo(Can::BE_AN_ADMIN);

    // Verificar que não ocorreu nenhuma consulta ao banco de dados
    DB::listen(fn ($q) => throw new Exception('Query executada'));
    $user->hasPermissionTo(Can::BE_AN_ADMIN);
    expect(true)->toBeTrue();
});

test('only be an admin users can see the admin items in the menu', function () {
    $user = User::factory()->create();

    actingAs($user)
        ->get(route('admin.dashboard'))
        ->assertDontSee('Admin');
});
