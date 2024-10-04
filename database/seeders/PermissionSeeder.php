<?php declare(strict_types = 1);

namespace Database\Seeders;

use App\Enums\Can;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        Permission::create(['key' => Can::BE_AN_ADMIN]);
    }
}
