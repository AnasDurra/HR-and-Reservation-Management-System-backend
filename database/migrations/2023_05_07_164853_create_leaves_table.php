<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('leaves', function (Blueprint $table) {
            $table->id('leave_id');
            $table->unsignedBigInteger('emp_id');
            $table->unsignedInteger('uid');
            $table->tinyInteger('state')->default(0);
            $table->time('leave_time')->nullable();
            $table->date('leave_date')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->tinyInteger('type')->default(0);

            $table->foreign('emp_id')->references('emp_id')->on('employees');

            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('leaves');
    }
};
