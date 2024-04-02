<?php

namespace App\Livewire;

use App\Mail\CandidateApplied;
use App\Models\Application;
use App\Models\Company;
use App\Models\Job;
use App\Models\Resume;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class ShowJob extends Component
{
    public Job $job;

    public Company $company;

    public function mount(Job $job, Company $company)
    {
        $this->job = $job;
        $this->company = $company;
    }

    public function render()
    {
        return view('livewire.show-job');
    }

    public function apply($job)
    {
        if (! Resume::where('user_id', auth()->id())->exists()) {
            Notification::make()->title('Resume Required')->body('Please create a resume to apply for this job.')->info()->send();

            return to_route('create.resume');
        }
        if (! auth()->check()) {
            Notification::make()->title('Login Required')->body('Please login to apply for this job.')->info()->send();

            return false;
        }
        if (auth()->user()->hasAnyRole(['employer', 'admin'])) {
            Notification::make()->title('Sorry !')->body('Employer / Admin cannot apply.')->info()->send();

            return false;
        }
        $check = Application::where(['user_id' => auth()->id(), 'job_id' => $job])->exists();
        if ($check) {
            Notification::make()->title('Already Applied')->body('You have already applied for this job.')->info()->send();
        } else {
            $companyId = Job::where('id', $job)->first()->company_id;
            Application::create([
                'user_id' => auth()->id(),
                'job_id' => $job,
                'company_id' => $companyId,
            ]);

            $email = Company::findOrFail($companyId)->email;
            $resume = Resume::where('user_id', auth()->id())->first();
            $resumePdf = storage_path().'/app/public/'.$resume->resume_file;
            $resumeData = $resume->toArray();
            $resumeData['name'] = auth()->user()->name;
            Mail::to('laravel.rajen@gmail.com')->send(new CandidateApplied($resumeData, $resumePdf));
            Notification::make()->title('Applied')->success()->send();
        }
    }
}
