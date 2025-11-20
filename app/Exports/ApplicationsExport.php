<?php
namespace App\Exports;
use App\Models\Application;
use Maatwebsite\Excel\Concerns\FromCollection;

class ApplicationsExport implements FromCollection
{
    protected $jobId;

    public function __construct($jobId)
    {
        $this->jobId = $jobId;
    }

    public function collection()
    {
        // Export pelamar HANYA untuk job ini
        return Application::where('job_id', $this->jobId)->get();
    }
}