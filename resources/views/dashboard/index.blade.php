@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Background Job Dashboard</h1>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Job Class</th>
                    <th>Method</th>
                    <th>Status</th>
                    <th>Retry Count</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($jobs as $job)
                    <tr>
                        <td>{{ $job->class }}</td>
                        <td>{{ $job->method }}</td>
                        <td>{{ $job->status }}</td>
                        <td>{{ $job->retry_count }}</td>
                        <td>
                            @if($job->status == 'running')
                                <form action="{{ route('dashboard.cancel', $job->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Cancel</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
