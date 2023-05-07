<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('emp_data', function (Blueprint $table) {
            $table->id('emp_data_id');
            $table->text('fields');
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('emp_data');
    }
};
