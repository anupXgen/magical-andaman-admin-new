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
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->text('title')->nullable();
            $table->longText('subtitle')->nullable();
            $table->text('author_name')->nullable();
            $table->text('path')->nullable();
            $table->text('size')->nullable();
            $table->tinyInteger('status')->length(1)->default(0)->comment('0=default,1=inactive');
            $table->tinyInteger('delete')->length(1)->default(0)->comment('0=default,1=deleted');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
