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

        $customers = Customer::factory(57)->create();
        Opportunity::factory(27)->recycle($customers)->create();
        $categories = Category::factory(7)->create();
        Product::factory(127)->recycle($categories)->create();

        $videos = Video::factory(35)->create();
        Summary::factory(45)->recycle($videos)->create();

    }
}
