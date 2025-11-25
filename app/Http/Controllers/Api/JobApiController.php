<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\JobVacancy as Job; 
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class JobApiController extends Controller
{
    /**
     * @OA\Get(
     * path="/api/jobs",
     * tags={"Jobs"},
     * summary="Ambil daftar semua lowongan",
     * description="Mengembalikan list data lowongan kerja",
     * @OA\Response(
     * response=200,
     * description="Berhasil ambil data",
     * @OA\JsonContent(
     * type="array",
     * @OA\Items(
     * @OA\Property(property="id", type="integer", example=1),
     * @OA\Property(property="title", type="string", example="Web Developer"),
     * @OA\Property(property="company", type="string", example="Tokopedia")
     * )
     * )
     * )
     * )
     */

    // GET ALL (Dengan Pencarian)
    public function index(Request $req)
    {
        $q = Job::query();

        // 1. Filter Keyword (Pencarian Umum) - Sudah ada di tutorial
        if ($req->filled('keyword')) {
            $kw = $req->keyword;
            $q->where(function($s) use ($kw) {
                $s->where('title', 'like', "%$kw%")
                ->orWhere('company', 'like', "%$kw%")
                ->orWhere('location', 'like', "%$kw%");
            });
        }

        // LATIHAN 1: Filter Spesifik (Company & Location)
        if ($req->filled('company')) {
            $q->where('company', 'like', '%' . $req->company . '%');
        }

        if ($req->filled('location')) {
            $q->where('location', 'like', '%' . $req->location . '%');
        }

        // LATIHAN 3: Pagination Dinamis
        // Ambil nilai 'per_page' dari URL, jika tidak ada default-nya 10
        $perPage = $req->get('per_page', 10);
        
        $jobs = $q->orderBy('created_at', 'desc')->paginate($perPage);
        
        return response()->json($jobs);
    }
    
    // GET DETAIL
    public function show($id)
    {
        $job = Job::find($id);
        if (!$job) return response()->json(['message' => 'Not Found'], 404);
        return response()->json($job);
    }

    // CREATE (Admin Only)
    public function store(Request $req)
    {
        // Cek Role
        if ($req->user()->role !== 'admin') {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $data = $req->validate([
            'title' => 'required',
            'description' => 'required',
            'location' => 'required',
            'company' => 'required',
            'salary' => 'nullable|integer',
        ]);

        $job = Job::create($data);
        return response()->json(['message' => 'Created', 'job' => $job], 201);
    }

}