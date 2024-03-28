<?php

namespace App\Livewire;

use App\Models\Job;
use App\Models\Tag;
use Filament\Forms;
use App\Models\Company;
use Filament\Forms\Get;
use Livewire\Component;
use Filament\Forms\Form;
use Filament\Support\RawJs;
use Illuminate\Contracts\View\View;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Support\Enums\MaxWidth;

class JobPost extends Component implements HasForms
{
    use InteractsWithForms;
    use InteractsWithActions;

    public ?array $data = [];

    public function mount()
    {
        $companyCount = Company::where('user_id', auth()->id())->count();
        if ($companyCount == 0) {
            Notification::make()->title('Create Company')->body('You don\'t have a company.')->info()->send();
            return to_route('create.company');
        }
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()->heading('Post Job')->schema([
                    TextInput::make('title')
                        ->required()
                        ->helperText('Example: "Senior Laravel Developer", "Software Engineer"')
                        ->live(debounce:true),
                    ColorPicker::make('hilight_color')
                        ->helperText('Pick a color that best represents your job')
                        ->live(debounce:true),
                    Select::make('employment_type')
                        ->options([
                            'full_time' => 'Full Time',
                            'part_time' => 'Part Time',
                            'contract' => 'Contract',
                        ])
                        ->live(debounce:true),
                    TextInput::make('apply_url')
                        ->required()
                        ->helperText('https://yourcompany.com/careers'),
                ])->columns(2),
                Section::make()->heading('Salary Range')->schema([
                    TextInput::make('salary_from')->prefixIcon('forkawesome-inr')
                        ->mask(RawJs::make('$money($input)'))
                        ->stripCharacters(',')
                        ->numeric()
                        ->helperText('Salary range should be in INR')
                        ->live(debounce:true),
                    TextInput::make('salary_to')->prefixIcon('forkawesome-inr')
                        ->mask(RawJs::make('$money($input)'))
                        ->stripCharacters(',')
                        ->numeric()
                        ->helperText('Salary range should be in INR')
                        ->live(debounce:true),
                ])->columns(2),
                Section::make()->heading('Location')->schema([
                    TextInput::make('location')
                        ->required()
                        ->helperText('Example: "Remote", "Remote / USA", "New York City", "Remote GMT-5", etc.')
                        ->live(debounce:true),
                ]),
                Section::make()->schema([
                    TagsInput::make('tags')
                        ->suggestions(Tag::query()->pluck('name')->all())
                        ->separator(',')
                        ->required()
                        ->helperText('Max 5 tags are allowed.')
                        ->live(debounce:true),
                ]),
                Forms\Components\Actions::make([
                    Forms\Components\Actions\Action::make('Preview')->modalContent(function(Get $get){
                            $companyLogo = Company::where('user_id', auth()->id())->first()->getFirstMediaUrl('company-logo');
                            $company = Company::where('user_id', auth()->id())->first();
                            $companyDetail['logo'] = $companyLogo;
                            $companyDetail['detail'] = $company;
                            return view('components.job-preview', [
                                'data' => $get,
                                'company' => $companyDetail
                            ]);
                        })->modalHeading('Preview')
                        ->modalSubmitAction(false)
                        ->modalCancelAction(false)
                        ->slideOver()
                        ->modalWidth(MaxWidth::SevenExtraLarge),
                ]),
            ])

            ->statePath('data')
            ->model(Job::class);
    }

    public function create()
    {
        $data = $this->form->getState();
        $data['user_id'] = auth()->id();
        $data['company_id'] = Company::where('user_id', auth()->id())->first()->id;
        $record = Job::create($data);
        $this->form->model($record)->saveRelationships();
        Notification::make()->title('Job Post Created')->success()->send();
        return to_route('home');
    }

    public function render(): View
    {
        return view('livewire.job-post');
    }
}
