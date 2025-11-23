<?php

namespace App\Exports;

// Impor interface WithHeadings
use Maatwebsite\Excel\Concerns\WithHeadings;

class JobImportTemplateExport implements WithHeadings
{
    /**
    * @return array
    */
    public function headings(): array
    {
        // Ini adalah header kolom yang akan dilihat admin
        // Sesuaikan urutannya dengan method import() di JobController
        return [
            'title',
            'description',
            'location',
            'company',
            'salary',
            'job_type'
        ];
    }
}