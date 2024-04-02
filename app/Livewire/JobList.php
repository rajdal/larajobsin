<?php

namespace App\Livewire;

use App\Models\Company;
use App\Models\Job;
use App\Models\Tag;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Get;
use Filament\Support\Enums\MaxWidth;
use Filament\Support\RawJs;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
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
            ->query(Job::query()->where('user_id', auth()->id()))
            ->columns([
                Grid::make()->schema([
                    Stack::make([
                        // ImageColumn::make('company.logo')->collection('company-logo')->size(20),
                        // SpatieMediaLibraryImageColumn::make('company.media')->collection('company-logo')->size(40)->circular(),
                        TextColumn::make('title')->size(TextColumn\TextColumnSize::Large)->weight('bold'),
                        TagsColumn::make('tags')->separator(',')->color('primary')->size(TextColumn\TextColumnSize::ExtraSmall),
                    ]),
                    // TextColumn::make('company.name')->weight('bold'),
                    TextColumn::make('employment_type'),
                    TextColumn::make('apply_url'),
                    // TextColumn::make('created_at')->sortable(),
                    // TextColumn::make('updated_at')->sortable(),
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
                DeleteAction::make()->iconButton(),
                EditAction::make()
                    ->iconButton()
                    ->slideOver()
                    ->modalWidth('screen')
                    ->form([
                        Section::make()->heading('Post Job')->schema([
                            TextInput::make('title')
                                ->required()
                                ->helperText('Example: "Senior Laravel Developer", "Software Engineer"')
                                ->live(onBlur: true),
                            ColorPicker::make('hilight_color')
                                ->helperText('Pick a color that best represents your job')
                                ->live(onBlur: true),
                            Select::make('employment_type')
                                ->options([
                                    'full_time' => 'Full Time',
                                    'part_time' => 'Part Time',
                                    'contract' => 'Contract',
                                ])
                                ->live(onBlur: true),
                            Checkbox::make('manage_by_self')->live()->helperText('Check if you want to handle application on your own')->label('I want to handle application on my own'),
                            TextInput::make('apply_url')->visible(function (Get $get) {
                                if (! empty($get('manage_by_self'))) {
                                    return true;
                                }

                                return false;
                            })->columnSpanFull()
                                ->required()
                                ->helperText('https://yourcompany.com/careers'),
                        ])->columns(2),
                        Section::make()->schema([
                            Group::make()->schema([
                                RichEditor::make('job_description')->requiredIf('manage_by_self', function (Get $get) {
                                    if (! empty($get('manage_by_self'))) {
                                        return false;
                                    }

                                    return true;
                                })->helperText('Add Job Description'),
                                RichEditor::make('job_requirement')->helperText('Add Job Requirement'),
                            ])->columns(2),
                            Group::make()->schema([
                                RichEditor::make('job_benefits')->helperText('Add Job Benefits'),
                                RichEditor::make('qualification')->helperText('Add required qualification for the Job.'),
                            ])->columns(2),
                            Group::make()->schema([
                                RichEditor::make('experience')->helperText('Add required Experience for the Job.'),
                                FileUpload::make('job_brochure')
                                    ->acceptedFileTypes(['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'])
                                    ->helperText('Only pdf, doc and docx files are accepted'),
                            ])->columns(2),

                        ])->visible(function (Get $get) {
                            if (! empty($get('manage_by_self'))) {
                                return false;
                            }

                            return true;
                        }),
                        Section::make()->heading('Salary Range')->schema([
                            TextInput::make('salary_from')->prefixIcon('forkawesome-inr')
                                ->mask(RawJs::make('$money($input)'))
                                ->stripCharacters(',')
                                ->numeric()
                                ->helperText('Salary range should be in INR')
                                ->live(onBlur: true),
                            TextInput::make('salary_to')->prefixIcon('forkawesome-inr')
                                ->mask(RawJs::make('$money($input)'))
                                ->stripCharacters(',')
                                ->numeric()
                                ->helperText('Salary range should be in INR')
                                ->live(onBlur: true),
                        ])->columns(2),
                        Section::make()->heading('Location')->schema([
                            TextInput::make('location')
                                ->required()
                                ->helperText('Example: "Remote", "Remote / USA", "New York City", "Remote GMT-5", etc.')
                                ->live(onBlur: true),
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
                        Actions::make([
                            Action::make('Preview')->modalContent(function (Get $get) {
                                $companyLogo = Company::where('user_id', auth()->id())->first()->getFirstMediaUrl('company-logo');
                                $company = Company::where('user_id', auth()->id())->first();
                                $companyDetail['logo'] = $companyLogo;
                                $companyDetail['detail'] = $company;

                                return view('components.job-preview', [
                                    'data' => $get,
                                    'company' => $companyDetail,
                                ]);
                            })->modalHeading('Preview')
                                ->modalSubmitAction(false)
                                ->modalCancelAction(false)
                                ->slideOver()
                                ->modalWidth(MaxWidth::SevenExtraLarge),
                        ]),
                    ]),
            ])
            ->bulkActions([
                //
            ])
            ->paginated()->paginatedWhileReordering(true);
    }

    public function render()
    {
        return view('livewire.job-list');
    }
}
