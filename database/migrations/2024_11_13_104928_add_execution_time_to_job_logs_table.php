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
            $table->float('execution_time')->nullable(); // Time taken by the job to run
            $table->timestamp('completed_at')->nullable(); // When the job was completed
            $table->text('error_message')->nullable(); // To store error message in case of failure
        });
    }

    public function down()
    {
        Schema::table('job_logs', function (Blueprint $table) {
            $table->dropColumn(['execution_time', 'completed_at', 'error_message']);
        });
    }
};
