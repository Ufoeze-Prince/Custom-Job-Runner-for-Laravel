<?php
// app/Http/Controllers/JobHistoryController.php
namespace App\Http\Controllers;

use App\Models\JobLog;
use App\BackgroundJobRunner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;

class JobHistoryController extends Controller
{
    protected $jobRunner;

    public function __construct(BackgroundJobRunner $jobRunner)
    {
        $this->jobRunner = $jobRunner;
    }

    public function index()
    {
        $jobLogs = JobLog::orderBy('priority', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('job-dashboard.index', compact('jobLogs'));
    }

    public function cancelJob($id)
    {
        try {
            // Find the job log by ID
            $jobLog = JobLog::findOrFail($id);

            // Update the job log status to 'cancelled' if it's running
            if ($jobLog->status == 'running') {
                $jobLog->update(['status' => 'cancelled']);
                // Logic for cancelling the job can be added here
                Log::info("Job {$jobLog->class}::{$jobLog->method} cancelled.");
            }

            return redirect()->route('job-dashboard.index')->with('success', 'Job cancelled successfully.');
        } catch (Exception $e) {
            return redirect()->route('job-dashboard.index')->with('error', 'Failed to cancel job.');
        }
    }

    public function retryJob($id)
    {
        try {
            // Find the failed job log by ID
            $jobLog = JobLog::findOrFail($id);

            // Retry the job if it failed
            if ($jobLog->status == 'failed') {
                $jobLog->update(['status' => 'queued', 'retry_count' => $jobLog->retry_count + 1]);
                // Re-run the job with the same parameters
                $job = [
                    'class' => $jobLog->class,
                    'method' => $jobLog->method,
                    'params' => json_decode($jobLog->params, true),
                    'priority' => $jobLog->priority,
                ];
                $this->jobRunner->runWithPriority([$job]);
            }

            return redirect()->route('job-dashboard.index')->with('success', 'Job retried successfully.');
        } catch (Exception $e) {
            return redirect()->route('job-dashboard.index')->with('error', 'Failed to retry job.');
        }
    }
}
