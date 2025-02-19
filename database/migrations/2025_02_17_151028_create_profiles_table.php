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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('state')->nullable();; 
            $table->string('country')->nullable();
            $table->text('about_me')->nullable(); 
            $table->bigInteger('number')->nullable(); 
            $table->bigInteger('job_experience')->nullable(); 
            $table->bigInteger('projects')->nullable(); 
            $table->bigInteger('awards')->nullable(); 
            $table->string('photo')->nullable();
            $table->json('personal_skills')->nullable();
            $table->json('professional_skills')->nullable();
            $table->json('education')->nullable();
            $table->json('experience')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
