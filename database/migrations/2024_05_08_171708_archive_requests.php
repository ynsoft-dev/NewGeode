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
        Schema::create('archive_requests', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('details_request');
            $table->date('request_date');
            $table->string('status', 20)->default('created');
            
            $table->foreignId('department_id')->constrained();
            $table->foreignId('direction_id')->constrained();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('archive_requests');
    }
};
