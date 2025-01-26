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
        Schema::create('users_feedback_systems', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->integer('c1_1')->nullable();
            $table->integer('c1_2')->nullable();
            $table->integer('c1_3')->nullable();
            $table->integer('c1_4')->nullable();
            $table->integer('c1_5')->nullable();
            $table->integer('c2_1')->nullable();
            $table->integer('c2_2')->nullable();
            $table->integer('c2_3')->nullable();
            $table->integer('c2_4')->nullable();
            $table->integer('c2_5')->nullable();
            $table->integer('c3_1')->nullable();
            $table->integer('c3_2')->nullable();
            $table->integer('c3_3')->nullable();
            $table->integer('c3_4')->nullable();
            $table->integer('c3_5')->nullable();
            $table->text('comment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_feedback_systems');
    }
};
