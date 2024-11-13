<?php

namespace App\Http\Controllers;

use App\BackgroundJobRunner;
// use App\JobLog;
use App\Models\JobLog;
use App\ExampleJob; 


class JobController extends Controller
{
    /**
     * Run jobs with priority.
     *
     * @return \Illuminate\Http\Response
     */
    public function runJobsWithPriority()
    {
        // Example of manually defining jobs with priority
        $jobs = [
            [
                'class' => \App\ExampleJob::class,
                'method' => 'sendMessage',
                'params' => ['message' => 'High priority message'],
                'priority' => 1,  // High priority
                'maxRetries' => 3,
                'delay' => 0
            ],
            [
                'class' => \App\ExampleJob::class,
                'method' => 'sendMessage',
                'params' => ['message' => 'Low priority message'],
                'priority' => 0,  // Low priority
                'maxRetries' => 3,
                'delay' => 0
            ]
        ];

        // Instantiate the job runner and run jobs with priority
        $jobRunner = new BackgroundJobRunner();
        $jobRunner->runWithPriority($jobs);

        return response()->json(['message' => 'Jobs are running with priority']);
    }

    /**
     * Fetch jobs from database and run with priority.
     *
     * @return \Illuminate\Http\Response
     */

     
    public function fetchAndRunJobs()
    {
        // Fetch jobs from the database
        $jobs = JobLog::where('status', 'pending')
            ->orderBy('priority', 'desc')
            ->get();

        // Convert jobs to array for runWithPriority
        $jobArray = $jobs->map(function ($job) {
            return [
                'class' => $job->class,
                'method' => $job->method,
                'params' => json_decode($job->params, true),  // Decode JSON params
                'priority' => $job->priority,
                'maxRetries' => 3,
                'delay' => 0
            ];
        })->toArray();

        // Instantiate the job runner and run jobs with priority
        $jobRunner = new BackgroundJobRunner();
        $jobRunner->runWithPriority($jobArray);

        return response()->json(['message' => 'Jobs are running with priority']);
    }


    public function dispatchJob()
    {
        // Insert a new job into the job_logs table
        JobLog::create([
            'class' => ExampleJob::class, // Specify the class to be executed
            'method' => 'sendMessage',              // Specify the method to be executed
            'params' => json_encode(['message' => 'This is a test message']), // Parameters (encoded as JSON)
            'priority' => 1, // Priority level (higher priority jobs should be lower numbers)
            'status' => 'pending', // Job status (can be 'pending', 'in-progress', 'completed', etc.)
        ]);

        return response()->json(['message' => 'Job has been added to the queue.']);
    }
}
