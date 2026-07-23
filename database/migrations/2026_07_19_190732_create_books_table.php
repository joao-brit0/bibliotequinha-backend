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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('subtitle')->nullable();

            $table->integer('publication_year')->nullable(); 
            
            $table->foreignId('publisher_id')->constrained('publishers')->restrictOnDelete();
            $table->foreignId('theme_id')->constrained('themes')->restrictOnDelete();

            $table->string('isbn'); 
            $table->integer('quantity')->default(1);
            
            $table->integer('number_of_pages')->nullable();
            $table->string('cutter_code')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
