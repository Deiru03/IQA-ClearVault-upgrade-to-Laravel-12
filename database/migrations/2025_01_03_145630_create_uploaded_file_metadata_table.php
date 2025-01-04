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
        Schema::create('uploaded_file_metadata', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('shared_clearance_id');
            $table->unsignedBigInteger('requirement_id');
            $table->string('file_name');
            $table->longText('file_content')->charset('binary')->nullable(); // Use longText with charset('binary')
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('shared_clearance_id')->references('id')->on('shared_clearances')->onDelete('cascade');
            $table->foreign('requirement_id')->references('id')->on('clearance_requirements')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('uploaded_file_metadata');
    }
};
