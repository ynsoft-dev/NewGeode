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
        Schema::create('archieve_request_details', function (Blueprint $table) {
            $table->id();

            $table->string('content');
            $table->date('extreme_date');
            $table->string('ref')->nullable();
            
            $table->date('destruction_date')->nullable();
            $table->string('location')->nullable();
            $table->string('status', 20)->nullable();

            
            $table->string('statusRequest', 20);
            $table->string('user',300);
            $table->foreignId('box_archive_request_id')->constrained();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('archieve_request_details');
    }
};
