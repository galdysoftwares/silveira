<?php declare(strict_types = 1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('type', 20)->default('customer');
            $table->string('name', 200);
            $table->string('email', 200)->unique()->index();
            $table->string('phone', 20)->unique()->nullable();
            $table->string('linkedin', 200)->nullable();
            $table->string('facebook', 200)->nullable();
            $table->string('instagram', 200)->nullable();
            $table->string('twitter', 200)->nullable();
            $table->string('address', 200)->nullable();
            $table->string('city', 100)->nullable();
            $table->string('state', 100)->nullable();
            $table->string('zip', 20)->nullable();
            $table->string('country', 100)->nullable();
            $table->integer('age')->nullable();
            $table->string('gender')->nullable();
            $table->string('company', 200)->nullable();
            $table->string('position', 200)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
