<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Validation\Rules\Password;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->validationMessages([
                        'required' => 'Nama tidak boleh kosong.',
                        'max' => 'Nama tidak boleh lebih dari :max karakter.',
                    ]),
                TextInput::make('email')
                    ->email()
                    ->required()
                    ->unique(User::class, 'email')
                    ->validationMessages([
                        'required' => 'Email wajib diisi.',
                        'email' => 'Format email tidak valid.',
                        'unique' => 'Email ini sudah terdaftar.',
                    ]),
                TextInput::make('password')
                    ->password()
                    ->required()
                    ->confirmed()
                    ->rule(Password::default())
                    ->dehydrateStateUsing(fn($state) => bcrypt($state))
                    ->validationMessages([
                        'required' => 'Password wajib diisi.',
                        'confirmed' => 'Konfirmasi password tidak cocok.',
                        'min' => 'Password harus memiliki minimal :min karakter.',
                    ]),
                TextInput::make('password_confirmation')
                    ->password()
                    ->required()
                    ->dehydrated(false)
                    ->label('Konfirmasi Password')
                    ->validationMessages([
                        'required' => 'Konfirmasi password wajib diisi.',
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('email')->searchable(),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable(),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
