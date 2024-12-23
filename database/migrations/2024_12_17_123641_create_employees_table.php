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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->integer('age');
            $table->string('position');
            $table->integer('salary');
            $table->date('joining_date');
            $table->tinyInteger('status')->default(1)->nullable()->comment('1 = Active, 2 = Suspended'); // Add a meaningful comment
            $table->unsignedBigInteger('role_id')->nullable()->comment('1 = Admin, 2 = Employee');;
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
