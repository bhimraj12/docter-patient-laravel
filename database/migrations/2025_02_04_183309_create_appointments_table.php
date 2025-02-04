<?php

use App\Models\V1\Master\AppointmentStatus;
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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('doctor_id');
            $table->date('appointment_date');
            $table->time('from_time');
            $table->time('to_time');
            $table->text('notes')->nullable();
            $table->tinyInteger('appointment_status_id')->nullable()->default(AppointmentStatus::PENDING);
            $table->boolean('status_id')->default(true);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();  
            $table->timestamps();
            $table->softDeletes();

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
        Schema::dropIfExists('appointments');
    }
};
