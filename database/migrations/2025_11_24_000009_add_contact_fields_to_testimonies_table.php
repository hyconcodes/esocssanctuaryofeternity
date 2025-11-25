<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('testimonies', function (Blueprint $table) {
            $table->string('gender')->nullable()->after('author');
            $table->string('email')->nullable()->after('gender');
            $table->string('phone')->nullable()->after('email');
            $table->string('country')->nullable()->after('phone');
        });
    }

    public function down(): void
    {
        Schema::table('testimonies', function (Blueprint $table) {
            $table->dropColumn(['gender','email','phone','country']);
        });
    }
};
