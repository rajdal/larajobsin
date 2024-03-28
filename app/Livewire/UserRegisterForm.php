<?php

namespace App\Livewire;

use Filament\Forms;
use App\Models\User;
use Livewire\Component;
use Filament\Forms\Form;
use Forms\Components\Button;
use Illuminate\Support\HtmlString;
use Illuminate\Contracts\View\View;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Section;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Actions\Action;
use Filament\Support\Enums\VerticalAlignment;
use Filament\Forms\Concerns\InteractsWithForms;

class UserRegisterForm extends Component implements HasForms
{
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
                Section::make()->heading('Create an Account')->schema([
                    TextInput::make('name')->required(),
                    TextInput::make('email')->required()->email()->unique(User::class, 'email'),
                    TextInput::make('password')->required()->password(),
                    TextInput::make('password_confirmation')->required()->password(),
                    Group::make()->schema([
                        Checkbox::make('terms')->label('I agree')->required(),
                        Actions::make([
                            Action::make('Login')->url(route('login')),
                        ])->verticalAlignment(VerticalAlignment::End),
                    ])->columns(2)
                ])
            ])
            ->statePath('data')
            ->model(User::class);
    }

    public function create()
    {
        $data = $this->form->getState();

        $record = User::create($data);

        Notification::make()->success()->title('Account created.')->send();

        return to_route('login');

        // $this->form->model($record)->saveRelationships();
    }

    public function render(): View
    {
        return view('livewire.user-register-form');
    }
}
