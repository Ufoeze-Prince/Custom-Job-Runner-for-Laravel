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
        Schema::create('job_logs', function (Blueprint $table) {
            $table->id();
            $table->string('class');     // The class of the job
            $table->string('method');    // The method to call in the job class
            $table->text('params');      // The parameters for the job (stored as JSON)
            $table->integer('priority'); // Priority of the job (higher is higher priority)
            $table->string('status')->default('pending'); // Status of the job (e.g., pending, running, completed, failed)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_logs', function (Blueprint $table) {
            //
        });
    }
};
