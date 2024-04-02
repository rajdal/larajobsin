<?php

namespace App\Livewire;

use App\Models\Company;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Livewire\Component;

class CompanyList extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public function table(Table $table): Table
    {
        return $table
            ->query(Company::query())
            ->heading('Companies')
            ->columns([
                TextColumn::make('name'),
                SpatieMediaLibraryImageColumn::make('logo')->collection('company-logo'),
            ])
            ->filters([
                // ...
            ])
            ->actions([
                EditAction::make()
                    ->slideOver()
                    ->modalWidth('7xl')
                    ->form([
                        Section::make()->schema([
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
                                    ->imagePreviewHeight('full'),
                            ])->columns(2),

                        ]),
                    ]),
            ])
            ->bulkActions([
                // ...
            ])->emptyStateActions([
                Action::make('create')
                    ->label('Create Company')
                    ->url(route('create.company'))
                    ->icon('heroicon-m-plus')
                    ->button(),
            ])
            ->paginated(false);
    }

    public function render()
    {
        return view('livewire.company-list');
    }
}
