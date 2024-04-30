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
        Schema::create('lead_survey_child', function (Blueprint $table) {
            $table->id();
            $table->string('child_name', 20);
            $table->char('child_age', 5);
            $table->string('child_education', 255);
            $table->string('child_habit', 255)->nullable();
            $table->string('child_food_details', 255)->nullable();
            $table->char('blood_group', 5);
            $table->date('date_of_birth');
            $table->char('national_birth_id', 20);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lead_survey_child');
    }
};
