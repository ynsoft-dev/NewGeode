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
        Schema::create('columns', function (Blueprint $table) {
            $table->id();
            $table->string('name', 20);
            // $table->string('ray', 20);
            // $table->integer('capacity');
            // $table->unsignedBigInteger('site_id');
            // $table->foreign('site_id')->references('id')->on('sites')->onDelete('cascade');
            // $table->unsignedBigInteger('ray_id');
            // $table->foreign('ray_id')->references('id')->on('rays')->onDelete('cascade');
            $table->foreignId('site_id')->constrained();
            $table->foreignId('ray_id')->constrained();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('columns');
    }
};
