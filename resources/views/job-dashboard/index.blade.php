<!-- resources/views/job-dashboard/index.blade.php -->
@extends('layouts.app')

@section('content')
    <h1>Job Dashboard</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>Class</th>
                <th>Method</th>
                <th>Status</th>
                <th>Execution Time</th>
                <th>Priority</th>
                <th>Started At</th>
                <th>Completed At</th>
                <th>Retry Count</th>
                <th>Error Message</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($jobLogs as $log)
                <tr>
                    <td>{{ $log->class }}</td>
                    <td>{{ $log->method }}</td>
                    <td>{{ $log->status }}</td>
                    <td>{{ $log->execution_time ?? 'N/A' }}</td>
                    <td>{{ $log->priority }}</td>
                    <td>{{ $log->started_at }}</td>
                    <td>{{ $log->completed_at }}</td>
                    <td>{{ $log->retry_count }}</td>
                    <td>{{ $log->error_message ?? 'N/A' }}</td>
                    <td>
                        @if($log->status == 'running')
                            <form action="{{ route('job-dashboard.cancel', $log->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-danger">Cancel</button>
                            </form>
                        @elseif($log->status == 'failed')
                            <form action="{{ route('job-dashboard.retry', $log->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-warning">Retry</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $jobLogs->links() }} <!-- Pagination links -->
@endsection
