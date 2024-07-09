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
        Schema::create('boxes', function (Blueprint $table) {
            $table->bigIncrements('id');
            
            $table->string('content');
            $table->date('extreme_date');
            

            $table->string('ref')->nullable();
            $table->date('destruction_date')->nullable()->default('UNLIMITED');
            $table->string('location')->nullable();
            $table->string('status', 20)->default('Available');


            $table->foreignId('archive_demand_id')->constrained()->cascadeOnDelete();
            $table->foreignId('archive_demand_details_id')->constrained()->cascadeOnDelete();

            $table->unsignedBigInteger('shelf_id')->nullable()->constrained('shelves');

            // Pour la modification de l'emplacement de la boite 
            $table->unsignedBigInteger('site_id')->nullable()->constrained('sites');
            $table->unsignedBigInteger('ray_id')->nullable()->constrained('rays');
            $table->unsignedBigInteger('column_id')->nullable()->constrained('columns');

            $table->string('request_number')->nullable();
            $table->date('transmission_date')->nullable();
            $table->date('return_date')->nullable();
            $table->softDeletes(); // Ajout pour les suppressions douces
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('boxes');
    }
};