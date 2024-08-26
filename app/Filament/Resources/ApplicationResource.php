<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Work;
use Filament\Tables;
use App\Models\Company;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\Application;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ApplicationResource\Pages;
use App\Filament\Resources\ApplicationResource\RelationManagers;

class ApplicationResource extends Resource
{
    protected static ?string $model = Application::class;

    protected static ?string $navigationIcon = 'heroicon-o-document';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Select::make('user_id')
                            ->relationship('user','name')
                            ->preload()
                            ->createOptionForm([
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('email')
                                    ->required()
                                    ->label('Email Address')
                                    ->email()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('password')            
                                    ->required()
                                    ->maxLength(10),
                                Forms\Components\TextInput::make('phone')->required(),
                            ]),
                        Forms\Components\Select::make('company_id')
                            ->options(Company::all()->pluck('name', 'id')->toArray())
                            ->reactive()
                            ->required()
                            ->searchable(),
                        Forms\Components\Select::make('work_id')
                            ->relationship('work','title')
                            ->reactive()
                            ->afterStateUpdated(fn( $state, Forms\Set $set)=>
                                
                                $set('city', Work::find($state)?->city))
                            ->options(function (callable $get) {
                                    $companyId = $get('company_id');
                                    if ($companyId) {
                                        return Work::where('company_id', $companyId)->pluck('title', 'id')->toArray();
                                    }
                                    return Work::all()->pluck('title', 'id')->toArray();
                            })
                            ->required(),
                       
                        Forms\Components\TextInput::make('city')
                    ])->columnSpan('full'),
                Forms\Components\Section::make('status')
                    ->schema([
                        Forms\Components\Toggle::make('reviewed')
                    ])
                
            ]);
       
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                Tables\Columns\TextColumn::make('id'),
                Tables\Columns\TextColumn::make('user.name'),
                Tables\Columns\TextColumn::make('work.title'),
                Tables\Columns\TextColumn::make('company.name'),
                Tables\Columns\IconColumn::make('reviewed')->boolean(),
                Tables\Columns\TextColumn::make('work.city'),
                Tables\Columns\TextColumn::make('applied')
                    ->date(),
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
            'index' => Pages\ListApplications::route('/'),
            'create' => Pages\CreateApplication::route('/create'),
            'edit' => Pages\EditApplication::route('/{record}/edit'),
        ];
    }
}
