<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->id('perm_id');
            $table->string('name', 50);
            $table->string('description', 50);
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('permissions');
    }
};
