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
        Schema::create('daily_posts', function (Blueprint $table) {
            $table->id();
            $table->date('date')->useCurrent();
            $table->integer('quote_id');
            $table->integer('term_id');
            $table->integer('video_id');
            $table->integer('photo_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_posts');
    }
};
