<?php

namespace App;

use App\Models\JobLog;
use Exception;
use Illuminate\Support\Facades\Log;


class BackgroundJobRunner
{
    /**
     * Run jobs with priority and delay.
     *
     * @param array $jobs
     * @return void
     */
    public function runWithPriority($jobs)
    {
        // Sort jobs by priority (lower numbers have higher priority)
        usort($jobs, function ($a, $b) {
            return $a['priority'] <=> $b['priority'];
        });

        foreach ($jobs as $job) {
            // Check if the job has a delay
            $delay = $job['delay'];
            if ($delay > 0) {
                // Delay the job execution by the specified amount of seconds
                sleep($delay);
            }

            // Update the job status to 'running' before execution
            JobLog::where('class', $job['class'])
                ->where('method', $job['method'])
                ->update(['status' => 'running']);

            try {
                // Run the job (your custom method for running jobs)
                $this->runBackgroundJob($job['class'], $job['method'], $job['params']);

                // Update the job status to 'completed' if the job ran successfully
                JobLog::where('class', $job['class'])
                    ->where('method', $job['method'])
                    ->update(['status' => 'completed']);
            } catch (Exception $e) {
                // Update the job status to 'failed' if an exception occurs
                JobLog::where('class', $job['class'])
                    ->where('method', $job['method'])
                    ->update(['status' => 'failed']);

                // Log the error or perform further error handling here
                // You could also log the exception to a log file or notify the admin
                Log::error('Job failed', ['error' => $e->getMessage()]);
            }
        }
    }

    /**
     * Run a background job.
     *
     * @param string $class
     * @param string $method
     * @param array $params
     * @return void
     */
    private function runBackgroundJob($class, $method, $params)
    {
        // Instantiate the class dynamically and call the method
        $jobInstance = app($class);
        if (method_exists($jobInstance, $method)) {
            call_user_func_array([$jobInstance, $method], $params);
        } else {
            throw new Exception("Method {$method} not found in {$class}");
        }
    }
}
