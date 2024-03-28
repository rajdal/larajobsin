<?php

namespace App\Livewire;

use Livewire\Component;
use Filament\Forms\Form;
use Filament\Forms\Components\Group;
use Illuminate\Support\Facades\Auth;
use Filament\Support\Enums\Alignment;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Section;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Forms\Components\Actions\Action;
use Filament\Support\Enums\VerticalAlignment;
use Filament\Forms\Concerns\InteractsWithForms;

class Login extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    // public function mount(): void
    // {
    //     $this->form->fill();
    // }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()->heading('Login')->schema([
                    TextInput::make('email')->required()->email(),
                    TextInput::make('password')->required()->password(),
                    Group::make()->schema([
                        Checkbox::make('remember_me'),
                        Actions::make([
                            Action::make('Register')->url(route('register')),
                        ])->verticalAlignment(VerticalAlignment::End),
                    ])->columns(2)
                ])
            ])->statePath('data');
    }


    public function login()
    {
        if(Auth::attempt(['email' => $this->data['email'], 'password' => $this->data['password']]))
        {
            Notification::make()->success()->title('Login Success')->body('Welcome ' . Auth::user()->name)->send();
            return redirect()->route('home');
        } else {
            Notification::make()->danger()->title('Login Failed')->body('Invalid email or password.')->send();
            return to_route('login');
        }
    }
    public function render()
    {
        return view('livewire.login');
    }
}
