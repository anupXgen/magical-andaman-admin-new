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
        Schema::create('package_styles', function (Blueprint $table) {
            $table->id();
            $table->integer('parent_id')->comment('package table id');
            $table->tinyInteger('couple')->length(1)->default(0)->comment('0=no,1=yes');
            $table->tinyInteger('honeymoon')->length(1)->default(0)->comment('0=no,1=yes');
            $table->tinyInteger('senior')->length(1)->default(0)->comment('0=no,1=yes');
            $table->tinyInteger('friends')->length(1)->default(0)->comment('0=no,1=yes');
            $table->tinyInteger('solo')->length(1)->default(0)->comment('0=no,1=yes');
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('package_styles');
    }
};
