<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('job_logs', function (Blueprint $table) {
            $table->timestamp('started_at')->nullable(); // Track when the job started
            $table->float('execution_time')->nullable(); // Track how long the job took
            $table->timestamp('completed_at')->nullable(); // Track when the job was completed
            $table->text('error_message')->nullable(); // Store error messages in case of failure
        });
    }

    public function down()
    {
        Schema::table('job_logs', function (Blueprint $table) {
            $table->dropColumn(['started_at', 'execution_time', 'completed_at', 'error_message']);
        });
    }
};
