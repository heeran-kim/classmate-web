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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->text('text');
            $table->integer('rating');

            $table->unsignedBigInteger('reviewee_id');
            $table->foreign('reviewee_id')->references('id')->on('users');

            $table->unsignedBigInteger('assessment_user_id');
            $table->foreign('assessment_user_id')->references('id')->on('assessment_user');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
