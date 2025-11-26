<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('memberships', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->string('name');
            $table->string('priesthood_office');
            $table->string('phone1');
            $table->string('phone2')->nullable();
            $table->text('relation_or_caregiver')->nullable();
            $table->date('dob');
            $table->text('address');
            $table->string('city');
            $table->string('state');
            $table->string('country');
            $table->string('occupation');
            $table->string('occupation_other')->nullable();
            $table->string('relationship_status');
            $table->string('spouse_name')->nullable();
            $table->unsignedTinyInteger('children_count')->nullable();
            $table->string('membership_year');
            $table->string('membership_id');
            $table->date('faith_grad_date')->nullable();
            $table->string('faith_department')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('memberships');
    }
};

