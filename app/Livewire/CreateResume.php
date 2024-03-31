<?php

namespace App\Livewire;

use Filament\Forms;
use App\Models\Resume;
use Filament\Forms\Components\FileUpload;
use Livewire\Component;
use Filament\Forms\Form;
use Illuminate\Contracts\View\View;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;

class CreateResume extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public bool $resume = false;

    public $updateRecord;

    public function mount()
    {
        $this->resume = Resume::where('user_id', auth()->id())->exists();
        if($this->resume){
            $this->updateRecord = Resume::where('user_id', auth()->id())->with('media')->first();
            $this->form->fill(Resume::where('user_id', auth()->id())->with('media')->first()->toArray());
        }else{
            $this->form->fill();
        }
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()->schema([
                    Textarea::make('address')->required(),
                    Group::make()->schema([
                        TextInput::make('phone')->required(),
                        TextInput::make('email')->required(),
                    ])->columns(2),
                    Group::make()->schema([
                        TextInput::make('linkedin_url')->required(),
                        TextInput::make('github_url')->required(),
                    ])->columns(2),
                    FileUpload::make('resume_file')
                        ->acceptedFileTypes(['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'])
                        ->helperText('Only pdf, doc and docx files are accepted')
                        ->required()->downloadable(),
                ])
            ])
            ->statePath('data')
            ->model(Resume::class);
    }

    public function create(): void
    {
        $data = $this->form->getState();
        // dd($data);
        $data['user_id'] = auth()->id();
        $record = $this->resume ? $this->updateRecord->update($data) : Resume::create($data);
        // dd($record);
        $this->form->model($record)->saveRelationships();
    }

    public function render(): View
    {
        return view('livewire.create-resume');
    }
}
