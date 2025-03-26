<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StudentResource\Pages;
use App\Filament\Resources\StudentResource\RelationManagers;
use App\Models\Student;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ColumnGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StudentResource extends Resource
{
    protected static ?string $model = Student::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $slug = 'siswa';
    protected static ?string $navigationGroup = 'Data Master';
    protected static ?string $navigationLabel = 'Siswa/i';
    protected static ?string $modelLabel = 'Siswa/i';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->required()->label('Nama Siswa/i')
                    ->validationMessages([
                        'required' => 'Nama Siswa/i wajib diisi',
                    ]),
                TextInput::make('nisn')->nullable()->unique(ignoreRecord: true)->label('NISN'),
                TextInput::make('nis')->nullable()->unique(ignoreRecord: true)->label('NIS'),
                Select::make('class_id')
                    ->relationship('schoolClass', 'name')
                    ->label('Kelas')
                    ->searchable()
                    ->native(false)
                    ->preload(),
                TextInput::make('place_of_birth')->nullable()->label('Tempat Lahir'),
                DatePicker::make('date_of_birth')->label('Tanggal Lahir')->native(false),
                Select::make('religion')
                    ->label('Agama')
                    ->options([
                        'islam' => 'Islam',
                        'kristen' => 'Kristen',
                        'katolik' => 'Katolik',
                        'hindu' => 'Hindu',
                        'buddha' => 'Buddha',
                        'konghucu' => 'Konghucu',
                        'lainnya' => 'Lainnya',
                    ])
                    ->searchable()
                    ->native(false),
                Textarea::make('address')->label('Alamat'),
                TextInput::make('phone')->nullable()->label('No Telepon'),
                Fieldset::make('Data Orang Tua')
                    ->schema([
                        TextInput::make('father_name')->label('Nama Ayah')->required()
                            ->validationMessages([
                                'required' => 'Nama ayah wajib diisi',
                            ]),
                        TextInput::make('father_phone')->nullable()->label('No Telepon Ayah'),
                        TextInput::make('mother_name')->label('Nama Ibu')->required()->validationMessages([
                            'required' => 'Nama ibu wajib diisi',
                        ]),
                        TextInput::make('mother_phone')->nullable()->label('No Telepon Ibu'),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Nama')->searchable(),
                TextColumn::make('nisn')->label('NISN')->searchable(),
                TextColumn::make('nis')->label('NIS')->searchable(),
                TextColumn::make('schoolClass.name')
                    ->label('Kelas')
                    ->searchable(),
                TextColumn::make('gender')->label('Jenis Kelamin')->searchable(),
                ColumnGroup::make('birth_info', [
                    TextColumn::make('place_of_birth')->searchable()->label('Tempat'),
                    TextColumn::make('date_of_birth')->searchable()->label('Tanggal'),
                ])->label('Kelahiran'),
                TextColumn::make('religion')->label('Agama')->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()->button()->color('info'),
                Tables\Actions\DeleteAction::make()->button(),
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
            'index' => Pages\ListStudents::route('/'),
            'create' => Pages\CreateStudent::route('/create'),
            'edit' => Pages\EditStudent::route('/{record}/edit'),
        ];
    }
}
