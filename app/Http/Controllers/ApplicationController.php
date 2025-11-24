<?php

namespace App\Http\Controllers;

use App\Notifications\NewApplicationNotification;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Jobs\SendApplicationMailJob;
use App\Mail\JobAppliedMail;
use App\Mail\ApplicationStatusMail;
use App\Models\JobVacancy;
use App\Models\Application;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Exports\ApplicationsExport; 
use Maatwebsite\Excel\Facades\Excel;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(JobVacancy $job) // Gunakan Route Model Binding
    {
        // Ambil lamaran HANYA untuk lowongan ini ($job)
        // 'with('user')' mengambil data user-nya sekalian (optimasi)
        $applications = $job->applications()->with('user')->get();

        // Kirim data ke view
        return view('applications.index', compact('applications', 'job'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $jobId)
    {
        // 1. Validasi: pastikan file adalah PDF, maks 2MB
        $request->validate([
            'cv' => 'required|mimes:pdf|max:2048',
        ]);

        // 2. Simpan file CV ke 'storage/app/public/cvs'
        $cvPath = $request->file('cv')->store('cvs', 'public');

        // 3. Simpan data lamaran ke database
        $application = Application::create([
            'user_id' => auth()->id(), // Ambil ID user yang sedang login
            'job_id' => $jobId,       // Ambil ID lowongan dari URL
            'cv' => $cvPath,          // Simpan path file CV
            'status' => 'Pending'     // Status default
        ]);

        $job = JobVacancy::find($jobId);

        dispatch(new SendApplicationMailJob($job, auth()->user()));

        // 3. KIRIM NOTIFIKASI KE SEMUA ADMIN
        $admins = User::where('role', 'admin')->get(); // Ambil semua admin
        foreach($admins as $admin) {
            $admin->notify(new NewApplicationNotification($application));
        }


        return back()->with('success', 'Lamaran berhasil dikirim! Cek email Anda.');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Application $application)
    {
        // Hanya update status
        $application->update([
            'status' => $request->status
        ]);

        // 2. Kirim Email Notifikasi Status (JAWABAN LATIHAN 3)
        Mail::to($application->user->email)->send(new ApplicationStatusMail($application));

        return back()->with('success', 'Status pelamar diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function export(JobVacancy $job)
    {
        return Excel::download(new ApplicationsExport($job->id), 'pelamar_' . $job->title . '.xlsx');
    }

    public function downloadCv(Application $application)
    {
        // Cek apakah file benar-benar ada
        if (!Storage::disk('public')->exists($application->cv)) {
            return back()->withErrors('File CV tidak ditemukan.');
        }

        // Gunakan Storage::download untuk memaksa download
        // 'public' adalah disk, $application->cv adalah path filenya (cth: 'cvs/file.pdf')
        return Storage::disk('public')->download($application->cv);
    }

}
