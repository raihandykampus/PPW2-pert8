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
}
