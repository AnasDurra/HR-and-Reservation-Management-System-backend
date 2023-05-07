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
        Schema::create('schedule_employees', function (Blueprint $table) {
            $table->id('sched_emp_id');
            $table->unsignedBigInteger('emp_id');
            $table->unsignedBigInteger('schedule_id');

            $table->foreign('emp_id')->references('emp_id')->on('employees');
            $table->foreign('schedule_id')->references('schedule_id')->on('schedules');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedule_employees');
    }
};
