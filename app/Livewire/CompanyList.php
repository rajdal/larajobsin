<?php

namespace App\Livewire;

use App\Models\Company;
use Livewire\Component;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Support\Contracts\TranslatableContentDriver;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;

class CompanyList extends Component implements HasTable, HasForms
{
    use InteractsWithTable;
    use InteractsWithForms;

    public function makeFilamentTranslatableContentDriver() : ?TranslatableContentDriver
    {
        return null;
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(Company::query())
            ->heading('Companies')
            ->columns([
                TextColumn::make('name'),
                SpatieMediaLibraryImageColumn::make('logo')->collection('company-logo')
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
