<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Notifications\JobPosted;
use Illuminate\Support\Facades\Notification;

class Job extends Model
{
    use HasFactory;
    
    protected $fillable = ['title', 'description', 'email'];

    public static function boot()
    {
        parent::boot();

        static::created(function ($job) {
            $existingJobs = Job::where('email', $job->email)->count();
            if ($existingJobs === 1) {
                Notification::route('mail', 'lesterbonbiono@gmail.com')->notify(new JobPosted($job));
            }
        });
    }
}
