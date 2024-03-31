<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Resume;
use App\Models\Company;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\Application;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ApplicationResource\Pages;
use App\Filament\Resources\ApplicationResource\RelationManagers;

class ApplicationResource extends Resource
{
    protected static ?string $model = Application::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(self::getEloquentQuery())
            ->columns([
                TextColumn::make('user.name'),
                TextColumn::make('job.title'),
                TextColumn::make('created_at')->label('Applied on')->date()
            ])
            ->filters([
                //
            ])
            ->actions([
                Action::make('Resume Download')->action(function(Application $record){
                    $resume = Resume::where('user_id', $record->user_id)->first();
                    $resumePdf = $resume->getMedia('candidate-resume')[0]->getPath();
                    return response()->download($resumePdf);
                })
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
            'index' => Pages\ListApplications::route('/'),
            // 'create' => Pages\CreateApplication::route('/create'),
            // 'edit' => Pages\EditApplication::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $authUser = auth()->user();
        $role = $authUser->getRoleNames()->first();
        if($role == 'admin'){
            return parent::getEloquentQuery();
        }else{
            $companyId = Company::where('user_id', $authUser->id)->first()->id;
            return parent::getEloquentQuery()->where('company_id', $companyId);
        }
    }
}
