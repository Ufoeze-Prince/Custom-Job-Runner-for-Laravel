# Custom Job Runner for Laravel

A custom background job runner for Laravel that runs jobs with priority, delay and retries. It logs every job's execution history (status, execution time, errors and retry count) and includes a web dashboard for monitoring and managing jobs.

## Features

- **Priority jobs** – higher-priority jobs run first
- **Job delays** – set a delay in seconds before a job starts
- **Job retry** – retry failed jobs, with each retry logged
- **Job cancellation** – cancel running jobs from the dashboard
- **Job history logging** – execution time, status and error messages stored in the database
- **Web dashboard** – view job logs, cancel jobs and retry failed jobs

## Tech stack

- PHP and Laravel
- MySQL
- Tailwind CSS and Vite for the dashboard
- PHPUnit for tests

## Requirements

- PHP 7.4 or higher
- Laravel 9.x or higher
- MySQL or another relational database
- Composer

## Installation

```bash
git clone https://github.com/Ufoeze-Prince/Custom-Job-Runner-for-Laravel.git
cd Custom-Job-Runner-for-Laravel
composer install
```

Set up the environment file and app key:

```bash
cp .env.example .env
php artisan key:generate
```

Add your database details to `.env`, then run the migrations to create the job log tables:

```bash
php artisan migrate
```

## Usage

### Running jobs with priority and delay

```php
$jobs = [
    [
        'class'    => 'App\Jobs\ExampleJob',
        'method'   => 'handle',
        'params'   => [$param1, $param2],
        'priority' => 1, // 1 is the highest priority
        'delay'    => 5, // seconds to wait before the job starts
    ],
    // Add more jobs here
];

$jobRunner = new BackgroundJobRunner();
$jobRunner->runWithPriority($jobs);
```

### Web dashboard

Open `/job-dashboard` in the browser. The dashboard shows each job's status, execution time, error message and retry count. From there you can cancel running jobs and retry failed ones.

### Job logs

Job logs are stored in the `job_logs` table. Each log records:

| Field | Description |
|---|---|
| Job class | The class that handles the job |
| Method | The method called to process the job |
| Status | `queued`, `running`, `completed` or `failed` |
| Execution time | How long the job took to run |
| Priority | The job's priority |
| Error message | The error if the job failed |

## Testing

```bash
php artisan test
```

## Author

**Ufoeze Prince** — [GitHub](https://github.com/Ufoeze-Prince)
