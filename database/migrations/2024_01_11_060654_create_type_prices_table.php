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
        Schema::create('type_prices', function (Blueprint $table) {
            $table->id();
            $table->integer('package_id')->comment('package table id');
            $table->integer('type_id')->comment('packagetype table id');
            $table->longText('subtitle')->nullable();
            $table-> decimal('cp_plan',9,2);
            $table-> decimal('map_with_dinner',9,2);
            $table-> decimal('actual_price',9,2);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('type_prices');
    }
};
