<?php

namespace App\Http\Controllers;

use App\BackgroundJobRunner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\JobLog;

class JobDashboardController extends Controller
{
    /**
     * Display the list of all jobs.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $jobs = JobLog::all(); // Fetch all job logs
        return view('dashboard.index', compact('jobs'));
    }

    /**
     * Cancel a running job.
     *
     * @param int $jobId
     * @return \Illuminate\Http\Response
     */
    public function cancelJob($jobId)
    {
        // Logic to cancel a job goes here (can be done by updating the database or a flag)
        JobLog::where('id', $jobId)->update(['status' => 'cancelled']);

        return redirect()->route('dashboard.index')->with('status', 'Job cancelled');
    }
}
