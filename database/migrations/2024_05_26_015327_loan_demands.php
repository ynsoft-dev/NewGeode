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
        Schema::create('loan_demands', function (Blueprint $table) {
            $table->id();
            $table->String('borrow_id');
            $table->foreignId('direction_id')->constrained();
            $table->foreignId('department_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->string('box_name');
            $table->string('type');
            $table->date('request_date');
            $table->date('return_date');
            $table->string('Status', 50);
            $table->integer('Value_Status');
            $table->string('reason')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loan_demands');
    }
};