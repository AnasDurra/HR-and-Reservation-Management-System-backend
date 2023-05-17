<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('relatives', function (Blueprint $table) {
            $table->id('relative_id');
            $table->unsignedBigInteger('emp_data_id');
            $table->unsignedBigInteger('emp_id');
            $table->timestamps();

            $table->foreign('emp_data_id')->references('emp_data_id')->on('emp_data');
            $table->foreign('emp_id')->references('emp_id')->on('employees');
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('relatives');
    }
};
