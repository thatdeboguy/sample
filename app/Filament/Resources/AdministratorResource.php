<?php

namespace App\Filament\Resources;

use Forms\Set;
use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\Administrator;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\AdministratorResource\Pages;
use App\Filament\Resources\AdministratorResource\RelationManagers;

class AdministratorResource extends Resource
{
    protected static ?string $model = Administrator::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-plus';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                
                Forms\Components\Select::make('user_id')
                    ->relationship('user','name')
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(fn($state, Forms\Set $set)=> 
                        $set('email', User::find($state)?->email))
                    ->afterStateUpdated(fn($state, Forms\Set $set)=>
                        $set('phone', User::find($state)?->phone)),
                Forms\Components\TextInput::make('email')
                    ->required()
                    ->label('Email Address')
                    ->email()
                    ->live(onBlur: true)
                    ->unique(),
                Forms\Components\TextInput::make('phone')
                    ->required()
                    ->tel(),
                Forms\Components\Select::make('roles')
                    ->options([
                        'administrator' => 'Administrator',
                        'employer' => 'Employer',
                        'administrator,employer' => 'Administrator,Employer',
                    ])
                    ->required(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                Tables\Columns\TextColumn::make('id'),
                Tables\Columns\TextColumn::make('user.name'),
                Tables\Columns\TextColumn::make('email'),
                Tables\Columns\TextColumn::make('roles'),
                Tables\Columns\TextColumn::make('last_login')
                    ->time(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ])
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
            'index' => Pages\ListAdministrators::route('/'),
            'create' => Pages\CreateAdministrator::route('/create'),
            'edit' => Pages\EditAdministrator::route('/{record}/edit'),
        ];
    }
}
/**<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AdministratorsResource\Pages;
use App\Filament\Resources\AdministratorsResource\RelationManagers;
use App\Models\Administrators;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AdministratorsResource extends Resource
{
    protected static ?string $model = Administrators::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-plus';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListAdministrators::route('/'),
            'create' => Pages\CreateAdministrators::route('/create'),
            'edit' => Pages\EditAdministrators::route('/{record}/edit'),
        ];
    }
}
 */