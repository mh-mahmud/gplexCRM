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
        Schema::create('lead_survey_people', function (Blueprint $table) {
            $table->id();
            $table->char('profession', 100);
            $table->char('number_of_child', 5);
            $table->string('permanent_address', 300)->nullable();
            $table->char('spouse_name', 20);
            $table->char('spouse_profession', 20)->nullable();
            $table->string('hobby', 300)->nullable();
            $table->char('monthly_income', 10);
            $table->text('child_details')->nullable();
            $table->text('parents_details')->nullable();
            $table->text('other_member_details')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lead_survey_people');
    }
};
