<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Job;
use Filament\Notifications\Notification;

class ApplicationController extends Controller
{
    public function apply(Job $job)
    {
        // dd($job);
        $check = Application::where(['user_id' => auth()->id(), 'job_id' => $job->id])->exists();
        if ($check) {
            Notification::make()->title('Already Applied')->info()->send();

            return back();
        }
        Application::create([
            'user_id' => auth()->id(),
            'job_id' => $job->id,
        ]);

        return back();

    }
}
