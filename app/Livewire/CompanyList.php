<?php

namespace App\Livewire;

use App\Models\Company;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Support\Contracts\TranslatableContentDriver;
use Filament\Tables\Actions\Action;
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
                // ...
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
