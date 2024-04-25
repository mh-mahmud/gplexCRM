<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('phone');
            $table->string('alternative_number')->nullable();
            $table->string('gender');
            $table->date('dob');
            $table->string('marital_status');
            $table->string('address');
            $table->integer('age');
            $table->string('company');
            $table->string('lead_status');
            $table->string('title');
            $table->integer('lead_rating');
            $table->string('website');
            $table->string('lead_owner');
            $table->string('industry');
            $table->integer('no_of_employee');
            $table->string('lead_source');
            $table->string('street');
            $table->string('city');
            $table->string('zip');
            $table->string('state');
            $table->string('country');
            $table->text('lead_notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
