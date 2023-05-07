<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_vacancies', function (Blueprint $table) {
            $table->id('job_vacancy_id');
            $table->unsignedBigInteger('dep_id');
            $table->string('name', 50);
            $table->text('description');
            $table->integer('count');

            $table->foreign('dep_id')->references('dep_id')->on('departments');

            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('job_vacancies');
    }
};
