<?php

namespace App\Livewire;

use App\Models\Application;
use App\Models\Job;
use App\Models\Tag;
use Carbon\Carbon;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class HomePage extends Component
{
    public Collection $jobs;

    public Collection $tags;

    public string $term = '';

    public function render(): View
    {
        $this->jobs = Job::when($this->term && $this->term != 'all', function ($query) {
            $query->where('tags', 'like', '%'.$this->term.'%');
        })->whereBetween('created_at', [Carbon::now()->subMonth(), Carbon::now()])->get();
        $this->tags = Tag::all();

        return view('livewire.home-page');
    }

    public function filter($tag)
    {
        // dd($tag);
        $this->term = $tag;
    }

    public function applyJob($job)
    {
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

            return to_route('job.details', ['job' => $job, 'company' => $companyId]);
        }
    }
}
