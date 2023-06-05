<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id('emp_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('emp_data_id');
            $table->unsignedBigInteger('job_app_id')->nullable();
            $table->date('start_date'); //TODO delete?
            $table->integer('leaves_balance');
            $table->unsignedBigInteger('schedule_id');
            $table->unsignedBigInteger('cur_title');
            $table->unsignedBigInteger('cur_dep');
            $table->timestamps();


            $table->foreign('schedule_id')->references('schedule_id')->on('schedules');
            $table->foreign('user_id')->references('user_id')->on('users');
            $table->foreign('emp_data_id')->references('emp_data_id')->on('emp_data');
            $table->foreign('job_app_id')->references('job_app_id')->on('job_applications');

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
