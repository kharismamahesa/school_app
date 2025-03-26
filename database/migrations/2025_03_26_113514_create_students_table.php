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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('nisn')->unique();
            $table->string('nis')->unique();
            $table->unsignedBigInteger('class_id');
            $table->string('place_of_birth')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->enum('gender', ['L', 'P']);
            $table->enum('religion', [
                'islam',
                'kristen',
                'katolik',
                'hindu',
                'buddha',
                'konghucu',
                'lainnya'
            ]);
            $table->text('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('father_name');
            $table->string('father_phone')->nullable();
            $table->string('mother_name');
            $table->string('mother_phone')->nullable();
            $table->timestamps();
            $table->foreign('class_id')->references('id')->on('school_classes')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
