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
        Schema::create('lab_results', function (Blueprint $table) {
    $table->id();

    $table->foreignId('patient_id')
        ->constrained()
        ->cascadeOnDelete();


    $table->foreignId('lab_test_id')
        ->constrained()
        ->restrictOnDelete();

    $table->string('result')->nullable();

    $table->string('unit')->nullable();

    $table->string('reference_range')->nullable();

    $table->text('notes')->nullable();

    $table->date('test_date');

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lab_results');
    }
};
