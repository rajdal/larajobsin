<?php

namespace App\Livewire;

use Filament\Forms;
use App\Models\Company;
use Livewire\Component;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;

class CompanyRegistrationForm extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()->heading('Create Company')->schema([
                    Group::make()->schema([
                        TextInput::make('name')->required(),
                        TextInput::make('address')->required(),
                    ])->columns(2),
                    Group::make()->schema([
                        TextInput::make('phone')->required(),
                        TextInput::make('email')->email()->required(),
                    ])->columns(2),
                    Group::make()->schema([
                        TextInput::make('website')->url()->required(),
                        TextInput::make('tag_line'),
                    ])->columns(2),
                    Group::make()->schema([
                        RichEditor::make('description'),
                        SpatieMediaLibraryFileUpload::make('logo')
                            ->collection('company-logo')
                            ->imageEditor()
                            ->imagePreviewHeight(245),
                    ])->columns(2),

                ])
            ])
            ->statePath('data')
            ->model(Company::class);
    }

    public function table(Table $table) : Table
    {
        return $table
            ->query(Company::query()->where('user_id', auth()->id()))
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                //
            ]);

    }

    public function create(): void
    {
        $data = $this->form->getState();
        $data['user_id'] = auth()->id();
        $record = Company::create($data);
        $this->form->model($record)->saveRelationships();
    }

    public function render(): View
    {
        return view('livewire.company-registration-form');
    }
}
