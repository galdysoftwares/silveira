<?php declare(strict_types = 1);

namespace Database\Seeders;

use App\Enums\Can;
use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::factory()
                    ->withPermission(Can::BE_AN_ADMIN)
                    ->create([
                        'name'     => 'Silveira Developer',
                        'email'    => 'admin@silveira.com',
                        'password' => 'password',
                    ]);

        $this->normalUsers();
        $this->deletedUsers($admin);
    }

    private function defaultDefinition(): array
    {
        return array_merge((new UserFactory())->definition(), [
            'password' => '$2y$10$Idvy/abS/kfVlfUzg3zxPOdoMlNIsvWHaGlafBBcnwSu8KrfRoDBu', // password
        ]);
    }

    public function normalUsers(): void
    {
        User::query()->insert(
            array_map(
                fn () => $this->defaultDefinition(),
                range(1, 50)
            )
        );
    }

    public function deletedUsers(User $admin): void
    {
        User::query()->insert(
            array_map(
                fn () => array_merge(
                    $this->defaultDefinition(),
                    [
                        'deleted_at' => now(),
                        'deleted_by' => $admin->id,
                    ]
                ),
                range(1, 50)
            )
        );
    }
}
