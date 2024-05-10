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
            $table->string('name');
            $table->string('details_request');
            $table->date('request_date');
            $table->string('status', 20)->default('created');

            $table->string('department');
            $table->string('direction');

            $table->string('user', 300);
            $table->foreignId('archive_request_id')->constrained()->onDelete('cascade');

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
