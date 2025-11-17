@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Daftar Pelamar untuk: {{ $job->title }}</h2>
    <a href="{{ route('jobs.index') }}" class="btn btn-secondary mb-3">Kembali ke Lowongan</a>

    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>Nama Pelamar</th>
                <th>Email Pelamar</th>
                <th>Status</th>
                <th>CV</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($applications as $app)
            <tr>
                <td>{{ $app->user->name }}</td>
                <td>{{ $app->user->email }}</td>
                <td>
                    @if($app->status == 'Pending')
                        <span class="badge bg-warning">Pending</span>
                    @elseif($app->status == 'Accepted')
                        <span class="badge bg-success">Accepted</span>
                    @else
                        <span class="badge bg-danger">Rejected</span>
                    @endif
                </td>
                <td>
                    <a href="{{ asset('storage/' . $app->cv) }}" target="_blank" class="btn btn-info btn-sm">
                        Lihat CV
                    </a>
                </td>
                <td>
                    <form action="{{ route('applications.update', $app->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="Accepted">
                        <button type{}"submit" class="btn btn-success btn-sm">Terima</button>
                    </form>
                    <form action="{{ route('applications.update', $app->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="Rejected">
                        <button type="submit" class="btn btn-danger btn-sm">Tolak</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">Belum ada pelamar.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection