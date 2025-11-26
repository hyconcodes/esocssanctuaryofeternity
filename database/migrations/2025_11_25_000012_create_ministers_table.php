<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('ministers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('role');
            $table->string('department')->nullable();
            $table->text('bio')->nullable();
            $table->string('photo_path')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ministers');
    }
};

