<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;




class JobVacancy extends Model
{
    //
    protected $table = 'job_vacancies';
    protected $fillable = [
        'title',
        'description',
        'location',
        'company',
        'logo',
        'salary',
        'job_type'
    ];
    // Relasi: 1 Lowongan bisa punya BANYAK Lamaran
    public function applications()
    {
        return $this->hasMany(Application::class, 'job_id');
    }
}
