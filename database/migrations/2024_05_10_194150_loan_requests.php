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
        Schema::create('loan_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('direction_id')->constrained();
            $table->foreignId('department_id')->constrained();
            $table->string('box_name');
            $table->string('kind');
            $table->date('request_date');
            $table->date('return_date');
            $table->string('Membership');
            $table->string('Status', 50);
            $table->integer('Value_Status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loan_requests');
    }
};