<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel; 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JobVacancy as Job;
use Illuminate\Support\Facades\Storage;
use App\Imports\JobsImport; 
use App\Exports\JobImportTemplateExport;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jobs = Job::all(); // Ambil SEMUA data lowongan
        // Kirim data 'jobs' ke view 'jobs.index'
        return view('jobs.index', compact('jobs'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('jobs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validasi data
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'location' => 'required',
            'company' => 'required',
            'logo' => 'image|mimes:jpg,png,jpeg|max:2048' // Validasi file gambar
        ]);

        // 2. Simpan file logo (jika ada)
        $logoPath = null;
        if ($request->hasFile('logo')) {
            // Simpan file ke folder 'storage/app/public/logos'
            // dan 'logos' akan jadi nama foldernya
            $logoPath = $request->file('logo')->store('logos', 'public');
        }

        // 3. Simpan data ke database
        Job::create([
            'title' => $request->title, 
            'description' => $request->description,
            'location' => $request->location,
            'company' => $request->company,
            'salary' => $request->salary,
            'job_type' => $request->job_type,
            'logo' => $logoPath
        ]);
        // 4. Arahkan kembali ke halaman index
        return redirect()->route('jobs.index')->with('success', 'Lowongan berhasil ditambahkan');
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $job = Job::findOrFail($id); // 1. Cari lowongan berdasarkan ID
        return view('jobs.show', compact('job')); // 2. Kirim datanya ke view 'jobs.show'
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $job = Job::findOrFail($id); // 1. Cari job berdasarkan ID
        return view('jobs.edit', compact('job')); // 2. Kirim data job ke view
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        // 1. Validasi Data
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'location' => 'required',
            'company' => 'required',
            'logo' => 'nullable|image|mimes:jpg,png,jpeg|max:2048' 
        ]);

        // 2. Cari data job
        $job = Job::findOrFail($id);

        // 3. Cek apakah ada file logo baru
        if ($request->hasFile('logo')) {
            // 3a. Hapus logo lama
            if ($job->logo) {
                Storage::delete('public/' . $job->logo);
            }

            // 3b. Simpan logo baru
            $logoPath = $request->file('logo')->store('logos', 'public');
        } else {
            // 3c. Pakai logo lama jika tidak ada logo baru
            $logoPath = $job->logo;
        }

        // 4. Update data ke database
        $job->update([
            'title' => $request->title,
            'description' => $request->description,
            'location' => $request->location,
            'company' => $request->company,
            'salary' => $request->salary,
            'job_type' => $request->job_type,
            'logo' => $logoPath
        ]);

        // 5. Arahkan kembali ke halaman index
        return redirect()->route('jobs.index')->with('success', 'Lowongan berhasil diperbarui');
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // 1. Cari data job
        $job = Job::findOrFail($id);

        // 2. Hapus file logo dari storage (jika ada)
        if ($job->logo) {
            Storage::delete('public/' . $job->logo);
        }

        // 3. Hapus data dari database
        $job->delete();

        // 4. Arahkan kembali ke halaman index
        return redirect()->route('jobs.index')->with('success', 'Lowongan berhasil dihapus');
    }

    public function downloadTemplate()
    {
        return Excel::download(new JobImportTemplateExport, 'template_lowongan.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate(['file' => 'required|mimes:xlsx,csv']);

        // try {
        //     Excel::import(new JobsImport, $request->file('file'));
        // } catch (\Illuminate\Database\QueryException $e) {
        //     if ($e->getCode() === 'HY000' && stripos($e->getMessage(), 'Incorrect integer value: \'Rejected\' for column \'salary\'') !== false) {
        //         return back()->with('error', 'Gaji harus berupa angka, misalnya "Rejected" tidak valid.');
        //     }

        //     throw $e;
        // }
        Excel::import(new JobsImport, $request->file('file'));

        return back()->with('success', 'Data lowongan berhasil di-import!');
    }
}
