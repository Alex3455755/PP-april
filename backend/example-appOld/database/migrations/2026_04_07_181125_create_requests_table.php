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
        Schema::create('requests', function (Blueprint $table) {
            $table->id();
            $table->integer('age');
            $table->integer('experience');
            $table->string('education');
            $table->float('rate',15,2);
            $table->foreignId('college_id')->constrained('colleges')
                ->onDelete('cascade');
            $table->foreignId('vacancie_id')->constrained('vacancies')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requests');
    }
};
