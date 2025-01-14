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
        Schema::create('package_features', function (Blueprint $table) {
            $table->id();
            $table->integer('parent_id')->comment('package table id');
            $table->tinyInteger('night_stay')->length(1)->default(0)->comment('0=no,1=yes');
            $table->tinyInteger('transport')->length(1)->default(0)->comment('0=no,1=yes');
            $table->tinyInteger('activity')->length(1)->default(0)->comment('0=no,1=yes');
            $table->tinyInteger('ferry')->length(1)->default(0)->comment('0=no,1=yes');
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('package_features');
    }
};
