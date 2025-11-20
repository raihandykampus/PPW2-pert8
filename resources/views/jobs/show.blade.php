@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            @if($job->logo)
                <img src="{{ asset('storage/' . $job->logo) }}" class="img-fluid rounded mb-3" alt="{{ $job->company }} logo" style="max-height: 250px; object-fit: cover; width: 100%;">
            @endif

            <h1 class="card-title">{{ $job->title }}</h1>
            <h4 class="card-subtitle mb-2 text-muted">{{ $job->company }}</h4>
            
            <p>
                <strong>Lokasi:</strong> {{ $job->location }}<br>
                <strong>Jenis Pekerjaan:</strong> <span class="badge bg-primary">{{ $job->job_type }}</span><br>
                <strong>Gaji:</strong> Rp {{ number_format($job->salary, 0, ',', '.') }}
            </p>

            <hr>

            <h5 class="mt-4">Deskripsi Pekerjaan</h5>
            <div>
                {!! nl2br(e($job->description)) !!} </div>

            <hr>

            @if(Auth::user()->role !== 'admin')
            <div class="mt-4">
                <h5>Lamar Pekerjaan Ini</h5>
                <form action="{{ route('apply.store', $job->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="cv" class="form-label">Upload CV (PDF, maks 2MB)</label>
                        <input type="file" name="cv" id="cv" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Kirim Lamaran</button>
                </form>
            </div>
            @endif

            <a href="{{ route('jobs.index') }}" class="btn btn-secondary mt-3">Kembali ke Daftar Lowongan</a>
        </div>
    </div>
</div>
@endsection