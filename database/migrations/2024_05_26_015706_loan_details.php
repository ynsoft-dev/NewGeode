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
        Schema::create('loan_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('loan_demand_id')->constrained()->onDelete('cascade');
            $table->String('borrow_id');
            $table->string('department_id');
            $table->string('direction_id');
            $table->string('type');
            $table->string('box_name');
            $table->date('request_date');
            $table->date('return_date');
            $table->string('Status', 50);
            $table->integer('Value_Status');
            $table->string('user', 300);
            // $table->string('accept_reason')->nullable(); // Ajout de la colonne accept_reason
            // $table->string('rejection_reason')->nullable(); // Ajout de la colonne rejection_reason
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loan_details');
    }
};