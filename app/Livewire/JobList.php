<?php

namespace App\Livewire;

use App\Models\Job;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\Layout\Grid;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TagsColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

class JobList extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public function table(Table $table): Table
    {
        return $table
            ->query(Job::query())
            ->columns([
                Grid::make()->schema([
                    Stack::make([
                        // ImageColumn::make('company.logo')->collection('company-logo')->size(20),
                        SpatieMediaLibraryImageColumn::make('company.media')->collection('company-logo')->size(40)->circular(),
                        TextColumn::make('title')->size(TextColumn\TextColumnSize::Large)->weight('bold'),
                        TagsColumn::make('tags')->separator(',')->color('primary')->size(TextColumn\TextColumnSize::ExtraSmall),
                    ]),
                    TextColumn::make('company.name')->weight('bold'),
                    TextColumn::make('employment_type'),
                    TextColumn::make('apply_url'),
                    TextColumn::make('created_at')->sortable(),
                    TextColumn::make('updated_at')->sortable(),
                ]),
            ])->contentGrid(['md' => 1])->recordUrl(function (Model $record) {
                return $record->apply_url;
            })
            ->filters([
                SelectFilter::make('employment_type')->options([
                    'full_time' => 'Full Time',
                    'part_time' => 'Part Time',
                    'contract' => 'Contract',
                ]),
            ])
            ->actions([
                //
            ])
            ->bulkActions([
                //
            ])
            ->paginated(false);
    }

    public function render()
    {
        return view('livewire.job-list');
    }
}
