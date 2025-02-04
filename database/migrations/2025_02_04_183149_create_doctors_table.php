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
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('prefix');
            $table->string('first_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('last_name')->nullable();            
            $table->string('specialization')->nullable();
            $table->string('description')->nullable();
            $table->text('qualification')->nullable();
            $table->text('experience')->nullable();
            $table->string('fee')->nullable(); //fees per hour
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();  
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnUpdate();
            $table->foreign('created_by')->references('id')->on('users')->cascadeOnUpdate();
            $table->foreign('updated_by')->references('id')->on('users')->cascadeOnUpdate();
            $table->foreign('deleted_by')->references('id')->on('users')->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};
