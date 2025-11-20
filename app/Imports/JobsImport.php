<?php
namespace App\Imports;
use App\Models\JobVacancy; 
use Maatwebsite\Excel\Concerns\ToModel;

class JobsImport implements ToModel
{
    public function model(array $row)
    {
        // Baris pertama (header) di Excel akan di-skip
        return new JobVacancy([
            'title'       => $row[0],
            'description' => $row[1],
            'location'    => $row[2],
            'company'     => $row[3],
            'salary'      => $row[4],
            'job_type'    => $row[5]
        ]);
    }
}