@extends('layouts.app')
@section('content')
<div class="container">
<h2>Edit Lowongan</h2> 

    <form action="{{ route('jobs.update', $job->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT') <input type="text" name="title" placeholder="Judul Lowongan" class="form-control mb-2" value="{{ $job->title }}">

        <textarea name="description" placeholder="Deskripsi" class="form-control mb-2">{{ $job->description }}</textarea>

        <input type="text" name="location" placeholder="Lokasi" class="form-control mb-2" value="{{ $job->location }}">

        <input type="text" name="company" placeholder="Nama Perusahaan" class="form-control mb-2" value="{{ $job->company }}">

        <input type="number" name="salary" placeholder="Gaji" class="form-control mb-2" value="{{ $job->salary }}">

        <label>Logo Perusahaan (Ganti jika ingin diubah)</label>
        <input type="file" name="logo" class="form-control mb-2">

        @if($job->logo)
            <img src="{{ asset('storage/' . $job->logo) }}" width="80" class="mb-2">
        @endif

        <label>Jenis Pekerjaan</label>
        <select name="job_type" class="form-control mb-2">
            <option value="Full-time" {{ $job->job_type == 'Full-time' ? 'selected' : '' }}>
                Full-time
            </option>
            <option value="Part-time" {{ $job->job_type == 'Part-time' ? 'selected' : '' }}>
                Part-time
            </option>
        </select>

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    </form>
</div>
@endsection