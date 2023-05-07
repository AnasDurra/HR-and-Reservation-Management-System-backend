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
            $table->unsignedBigInteger('req_stat_id');
            $table->text('description');

            $table->foreign('emp_id')->references('emp_id')->on('employees');
            $table->foreign('req_stat_id')->references('req_stat_id')->on('request_statuses');

            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('shift_requests');
    }
};
