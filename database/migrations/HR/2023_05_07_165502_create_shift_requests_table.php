<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shift_requests', function (Blueprint $table) {
            $table->id('shift_req_id');
            $table->unsignedBigInteger('emp_id');
            $table->unsignedBigInteger('req_stat')->default('1');
            $table->text('description');
            $table->time('new_time_in');
            $table->time('new_time_out');
            $table->date('start_date');
            $table->date('end_date');

            $table->foreign('emp_id')->references('emp_id')->on('employees')->cascadeOnDelete();
            $table->softDeletes();
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('shift_requests');
    }
};
