<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\JobVacancy as Job;
use Illuminate\Http\Request;

class ApplicationApiController extends Controller
{
    // GET: Lihat semua lamaran (Admin Only)
    public function index(Request $req)
    {
        // Cek apakah user adalah admin
        if ($req->user()->role !== 'admin') {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        // Ambil data lamaran beserta relasi user & job
        $apps = Application::with(['user', 'job'])
            ->latest()
            ->paginate($req->get('per_page', 10));

        return response()->json($apps);
    }

    // POST: Lamar Pekerjaan (Job Seeker)
    public function store(Request $req, Job $job)
    {
        $req->validate([
            'cv' => 'required|file|mimes:pdf|max:2048'
        ]);

        // Upload CV
        $cvPath = $req->file('cv')->store('cvs', 'public');

        // Simpan ke Database
        $app = Application::create([
            'user_id' => $req->user()->id,
            'job_id' => $job->id,
            'cv' => $cvPath,
            'status' => 'Pending'
        ]);

        return response()->json(['message' => 'Application submitted', 'application' => $app], 201);
    }
    
    // PATCH: Update Status Lamaran (Admin Only) - LATIHAN 2
    public function updateStatus(Request $req, $id)
    {
        // 1. Cek Admin
        if ($req->user()->role !== 'admin') {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        // 2. Validasi Input
        $req->validate([
            'status' => 'required|in:Accepted,Rejected,Pending'
        ]);

        // 3. Cari Aplikasi
        $app = Application::find($id);
        if (!$app) {
            return response()->json(['message' => 'Application not found'], 404);
        }

        // 4. Update Status
        $app->update(['status' => $req->status]);

        return response()->json([
            'message' => 'Status updated',
            'application' => $app
        ]);
    }
}