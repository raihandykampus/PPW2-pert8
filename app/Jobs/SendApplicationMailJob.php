<?php

namespace App\Jobs;


use Illuminate\Support\Facades\Mail;
use App\Mail\JobAppliedMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendApplicationMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $job;
    public $user;
    /**
     * Create a new job instance.
     */
    public function __construct($job, $user)
    {
        $this->job = $job;
        $this->user = $user;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        // Kita perlu mencari object Application dulu
        // (Asumsi: kita ubah __construct Job ini juga untuk menerima $application, 
        //  tapi biar cepat, kita query saja berdasarkan user & job yang ada)
        
        $app = \App\Models\Application::where('user_id', $this->user->id)
                ->where('job_id', $this->job->id)
                ->latest()
                ->first();

        if($app) {
            Mail::to($this->user->email)->send(new JobAppliedMail($app));
        }
    }
}
