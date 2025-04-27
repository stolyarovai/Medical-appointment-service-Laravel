<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('specialization')->nullable();
            $table->string('specialty');
            $table->text('bio')->nullable();
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('profile_picture')->default('none.png');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};
