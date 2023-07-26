<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->UnsignedBigInteger('education_level_id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique()->nullable();
            $table->string('username')->unique();
            $table->string('password');
            $table->string('job');
            $table->date('birth_date');
            $table->string('phone')->nullable();
            $table->string('phone_number');
            $table->integer('martial_status');
            $table->integer('num_of_children');
            $table->string('national_number');
            $table->text('profile_picture')->nullable();
            $table->boolean('verified')->default(false);
            $table->boolean('blocked')->default(false);

            $table->foreign('education_level_id')->references('id')->on('educational_levels')->onDelete('cascade');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};