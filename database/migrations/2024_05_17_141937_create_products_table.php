<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('code', 15)->unique();
            $table->string('name');
            $table->string('description', 1024)->nullable();
            $table->decimal('price', 20, 2)->default(0)->unsigned();
            $table->string('type');
            $table->string('photo');
            $table->integer('last_new_stocks')->default(0)->unsigned()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
