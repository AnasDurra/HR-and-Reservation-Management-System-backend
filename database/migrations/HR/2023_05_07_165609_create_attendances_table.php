<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id('attendance_id');
            $table->unsignedBigInteger('emp_id');
            $table->unsignedInteger('uid')->default(0);;
            $table->tinyInteger('state')->default(0);
            $table->time('attendance_time');
            $table->date('attendance_date');
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('type')->default(0);

            $table->foreign('emp_id')->references('emp_id')->on('employees')->onDelete('cascade');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
