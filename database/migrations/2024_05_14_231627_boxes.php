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
            $table->string('status', 20)->nullable();


            $table->foreignId('archive_request_id')->constrained()->cascadeOnDelete();
            $table->foreignId('archieve_request_details_id')->constrained()->cascadeOnDelete();
            
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