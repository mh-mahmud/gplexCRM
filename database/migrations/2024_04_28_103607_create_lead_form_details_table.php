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
        Schema::create('lead_form_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('form_id');
            $table->string('field_name');
            $table->string('field_value');
            $table->integer('character_length');
            $table->boolean('is_index');
            $table->boolean('is_null');
            $table->boolean('is_unique');
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('form_id')->references('id')->on('leads_forms')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lead_form_details');
    }
};
