# Custom-Job-Runner-for-Laravel
This is a custom background job runner for Laravel, allowing you to manage background jobs with priority, delay, and retries. The system tracks job execution history, including status, execution time, errors, and retry counts. It also provides an optional web-based dashboard for monitoring jobs and their statuses.

Features
Job History Logging: Track execution time, status, and error messages.
Priority Jobs: Jobs are processed based on priority (higher priority jobs run first).
Job Delays: Add delays before a job starts executing.
Job Retry: Retry failed jobs with automatic logging of retries.
Job Cancellation: Cancel running jobs directly from the dashboard.
Web-Based Dashboard: Monitor job status, view logs, cancel jobs, and retry failed jobs.
Prerequisites
PHP >= 7.4
Laravel 9.x or higher
MySQL or another relational database
Installation
Clone the repository:

git clone <repository-url>
cd <project-directory>
Install dependencies:

Run composer install to install the required Laravel packages.

composer install
Set up your .env file:

Copy the .env.example file to .env and configure your database and other necessary environment variables.

cp .env.example .env
php artisan key:generate
Run the migrations:

The migration will create the necessary tables for tracking job logs.

php artisan migrate
If the migration encounters errors about existing columns (e.g., execution_time), ensure that the table is updated correctly, or reset it as necessary.

Usage
1. Running Jobs with Priority and Delay
You can define and run jobs with priority and delay by passing the following parameters:

$jobs = [
    [
        'class' => 'App\Jobs\ExampleJob',
        'method' => 'handle',
        'params' => [$param1, $param2],
        'priority' => 1, // 1 being highest priority
        'delay' => 5,    // delay in seconds before the job starts
    ],
    // Add more jobs here
];

$jobRunner = new BackgroundJobRunner();
$jobRunner->runWithPriority($jobs);
2. Web Dashboard
Access the dashboard via /job-dashboard.
The dashboard displays job logs with their statuses, execution times, error messages, and retry counts.
You can cancel running jobs or retry failed jobs via the dashboard interface.
3. Job Logs
Job logs are stored in the job_logs table and can be viewed on the dashboard. Logs include:

Job Class: The class that handles the job.
Method: The method invoked to process the job.
Status: The status of the job (queued, running, completed, failed).
Execution Time: The time it took to execute the job.
Priority: The priority of the job (higher priority jobs run first).
Error Message: The error message if the job failed.
Web Dashboard Screenshots
(Optional) Include screenshots of the dashboard interface here to provide a visual overview of the job status.

Optional Advanced Features
1. Job Delays
You can specify a delay in seconds for each job, which will be respected before the job execution starts.

2. Job Priority
Jobs with higher priority will be processed before those with lower priority.

Testing
Run tests using PHPUnit:

php artisan test
Test Job Execution: Create a simple job and dispatch it using the BackgroundJobRunner to ensure that job execution, logging, and priority handling work as expected.

Contribution
Fork this repository.
Create a new feature branch.
Commit your changes.
Push your changes to your fork.
Submit a pull request.
License
This project is licensed under the MIT License – see the LICENSE file for details.

Notes:
Customize the JobRunner: Modify the job runner to adjust to the specific logic of your background jobs, like managing queues, or integrating with external systems.
Error Handling: Ensure the job history is always updated with meaningful error messages in case of failures.
Dashboard Improvements: You can further improve the dashboard by adding features like job filtering by status, sorting by execution time, and more detailed job parameters.
This README should provide all necessary information to install, use, and extend the custom job runner with a web-based dashboard.
