<?php declare(strict_types = 1);

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\{Category, Customer, Opportunity, Product, Summary, Video};
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            PermissionSeeder::class,
            UsersSeeder::class,
        ]);

        $customers = Customer::factory(2)->create();
        Opportunity::factory(5)->recycle($customers)->create();
        $categories = Category::factory(2)->create();
        Product::factory(5)->recycle($categories)->create();

        Video::factory()->create();
        Summary::factory()->create();

    }
}
