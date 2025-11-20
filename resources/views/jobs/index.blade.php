@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Daftar Lowongan</h2>

    <a href="{{ route('jobs.create') }}" class="btn btn-success mb-3">Tambah Lowongan</a>
    <div class="row">
        @if($jobs->isEmpty())
        <div class="col-12">
            <p class="text-center">Belum ada data lowongan.</p>
        </div>
        @else
        @foreach($jobs as $job)
        <a href="{{ route('applications.export', $job->id) }}" class="btn btn-success mb-3">
            Export ke Excel
        </a>
        <form action="{{ route('jobs.import') }}" method="POST" enctype="multipart/form-data" class="mb-3">
            @csrf
            <div class="input-group">
                <input type="file" name="file" class="form-control" required>
                <button type="submit" class="btn btn-info">Import Lowongan</button>
            </div>
        </form>

        <div class="col-md-4 mb-4"> <div class="card h-100">
                @if($job->logo)
                    <img src="{{ asset('storage/' . $job->logo) }}" class="card-img-top" alt="{{ $job->company }} logo" style="height: 200px; object-fit: cover;">
                @else
                    <img src="https://via.placeholder.com/400x200.png?text=No+Logo" class="card-img-top" alt="No Logo">
                @endif
                
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">
                        <a href="{{ route('jobs.show', $job->id) }}" class="text-decoration-none">
                            {{ $job->title }}
                        </a>
                    </h5>
                    <h6 class="card-subtitle mb-2 text-muted">{{ $job->company }}</h6>
                    <p class="card-text">
                        <strong>Lokasi:</strong> {{ $job->location }}<br>
                        
                        <strong>Gaji:</strong> Rp {{ number_format($job->salary, 0, ',', '.') }}<br>
                        
                        <strong>Jenis:</strong> <span class="badge bg-primary">{{ $job->job_type }}</span>
                    </p>
                    
                    <div class="mt-auto"> 

                        @if(Auth::user()->role === 'admin')
                            <a href="{{ route('applications.index', $job->id) }}" class="btn btn-info btn-sm">Pelamar</a> 
                            <a href="{{ route('jobs.edit', $job->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('jobs.destroy', $job->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm" onclick="return confirm('Hapus data?')">Hapus</button>
                            </form>
                        @else
                            <form action="{{ route('apply.store', $job->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="input-group">
                                    <input type="file" name="cv" class="form-control form-control-sm" required>
                                    <button type="submit" class="btn btn-primary btn-sm">Lamar</button>
                                </div>
                            </form>
                        @endif

                        </div>
                </div>
            </div>
        </div>
        @endforeach
    @endif
</div>
</div>
@endsection