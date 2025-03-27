<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HolidayResource\Pages;
use App\Filament\Resources\HolidayResource\RelationManagers;
use App\Models\Holiday;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class HolidayResource extends Resource
{
    protected static ?string $model = Holiday::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';

    protected static ?string $slug = 'harilibur';
    protected static ?string $navigationGroup = 'Data Master';
    protected static ?string $navigationLabel = 'Hari Libur';
    protected static ?string $modelLabel = 'Hari Libur';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Hari Peringatan')
                    ->required()
                    ->validationMessages([
                        'required' => 'Hari Peringatan wajib diisi',
                    ]),
                DatePicker::make('date')->label('Tanggal')->native(false),
                Select::make('type')
                    ->label('Tipe')
                    ->options([
                        'nasional' => 'Nasional',
                        'agama' => 'Agama',
                        'sekolah' => 'Sekolah',
                    ])
                    ->searchable()
                    ->native(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Hari Peringatan')->searchable(),
                TextColumn::make('date')->label('Tanggal')->searchable(),
                TextColumn::make('type')->label('Tipe')->searchable(),
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
            'index' => Pages\ListHolidays::route('/'),
            'create' => Pages\CreateHoliday::route('/create'),
            'edit' => Pages\EditHoliday::route('/{record}/edit'),
        ];
    }
}
