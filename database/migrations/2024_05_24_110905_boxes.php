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
            $table->date('destruction_date')->nullable();
            $table->string('location')->nullable();
            $table->string('status', 20)->default('Available');


            $table->foreignId('archive_demand_id')->constrained()->cascadeOnDelete();
            $table->foreignId('archive_demand_details_id')->constrained()->cascadeOnDelete();

            $table->unsignedBigInteger('shelf_id')->nullable()->constrained('shelves');

            
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