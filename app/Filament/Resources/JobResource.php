<?php

namespace App\Filament\Resources;

use App\Models\Job;
use App\Models\Tag;
use Filament\Forms;
use Filament\Tables;
use App\Models\Company;
use Filament\Forms\Get;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Support\RawJs;
use Filament\Resources\Resource;
use Filament\Support\Enums\MaxWidth;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Checkbox;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\ColorPicker;
use App\Filament\Resources\JobResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\JobResource\RelationManagers;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;

class JobResource extends Resource
{
    protected static ?string $model = Job::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()->heading('Post Job')->schema([
                    TextInput::make('title')
                        ->required()
                        ->helperText('Example: "Senior Laravel Developer", "Software Engineer"')
                        ->live(onBlur:true),
                    ColorPicker::make('hilight_color')
                        ->helperText('Pick a color that best represents your job')
                        ->live(onBlur:true),
                    Select::make('employment_type')
                        ->options([
                            'full_time' => 'Full Time',
                            'part_time' => 'Part Time',
                            'contract' => 'Contract',
                        ])
                        ->live(onBlur:true),
                    Checkbox::make('manage_by')->live()->helperText('Check if you want to handle application on your own')->label('I want to handle application on my own'),
                    TextInput::make('apply_url')->visible(function(Get $get){
                        if(!empty($get('manage_by'))){
                            return true;
                        }
                        return false;
                    })->columnSpanFull()
                        ->required()
                        ->helperText('https://yourcompany.com/careers'),
                ])->columns(2),
                Section::make()->heading('Salary Range')->schema([
                    TextInput::make('salary_from')->prefixIcon('forkawesome-inr')
                        ->mask(RawJs::make('$money($input)'))
                        ->stripCharacters(',')
                        ->numeric()
                        ->helperText('Salary range should be in INR')
                        ->live(onBlur:true),
                    TextInput::make('salary_to')->prefixIcon('forkawesome-inr')
                        ->mask(RawJs::make('$money($input)'))
                        ->stripCharacters(',')
                        ->numeric()
                        ->helperText('Salary range should be in INR')
                        ->live(onBlur:true),
                ])->columns(2),
                Section::make()->heading('Location')->schema([
                    TextInput::make('location')
                        ->required()
                        ->helperText('Example: "Remote", "Remote / USA", "New York City", "Remote GMT-5", etc.')
                        ->live(onBlur:true),
                ]),
                Section::make()->schema([
                    TagsInput::make('tags')
                        ->suggestions(Tag::query()->pluck('name')->all())
                        ->separator(',')
                        ->required()
                        ->tagPrefix('#')
                        ->rules(['max:5'])
                        ->helperText('Max 5 tags are allowed.')
                        ->live(onBlur: true),
                ]),
                // Forms\Components\Actions::make([
                //     Forms\Components\Actions\Action::make('Preview')->modalContent(function (Get $get) {
                //         $companyLogo = Company::where('user_id', auth()->id())->first()->getFirstMediaUrl('company-logo');
                //         $company = Company::where('user_id', auth()->id())->first();
                //         $companyDetail['logo'] = $companyLogo;
                //         $companyDetail['detail'] = $company;

                //         return view('components.job-preview', [
                //             'data' => $get,
                //             'company' => $companyDetail,
                //         ]);
                //     })->modalHeading('Preview')
                //         ->modalSubmitAction(false)
                //         ->modalCancelAction(false)
                //         ->slideOver()
                //         ->modalWidth(MaxWidth::SevenExtraLarge),
                // ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->searchable()->sortable(),
                TextColumn::make('company.name')->searchable()->sortable(),
                TextColumn::make('company.user.name'),
                TextColumn::make('tags')
                // ImageColumn::make('logo')->defaultImageUrl(function(Model $record){
                //     dd($record);
                // }),
                // SpatieMediaLibraryImageColumn::make('logo'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()->iconButton(),
                Tables\Actions\DeleteAction::make()->iconButton(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListJobs::route('/'),
            'create' => Pages\CreateJob::route('/create'),
            'edit' => Pages\EditJob::route('/{record}/edit'),
        ];
    }
}
