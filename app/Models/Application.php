<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

        protected $fillable = [
            'user_id',
            'job_id',
            'cv',
            'status'
        ];

        // Relasi: 1 Lamaran dimiliki oleh 1 User
        public function user()
        {
            return $this->belongsTo(User::class);
        }

        // Relasi: 1 Lamaran dimiliki oleh 1 Lowongan
        public function job()
        {
            return $this->belongsTo(JobVacancy::class, 'job_id');
        }
}
