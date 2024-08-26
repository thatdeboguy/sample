<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Work;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\WorkResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\WorkResource\RelationManagers;
use App\Filament\Resources\WorkResource\RelationManagers\ApplicationsRelationManager;

class WorkResource extends Resource
{
    protected static ?string $model = Work::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

   
    protected static ?string $navigationLabel = 'Jobs';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                
                Forms\Components\TextInput::make('title')
                    ->required(),
                Forms\Components\Select::make('city')
                    ->options([
                        'nicosia' => 'Nicosia',
                        'famagusta' => 'Famagusta',
                        'guzelyurt' => 'Guzelyurt',
                        'kyrenia' => 'Kyrenia',
                        'lefke' => 'Lefke',
                        'other'=> 'Other',
                    ]),
                
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Company')
                            ->schema([
                                Forms\Components\Select::make('company_id')
                                    ->searchable()
                                    ->relationship('company', 'name')
                                    ->required(),
                                Forms\Components\Toggle::make('published')
                                    ->required(),
                                ]),
                            
                            ])->columnSpan('full'),         
                                     
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id'),
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('company.name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\IconColumn::make('published')->boolean(),
                Tables\Columns\TextColumn::make('last_modified')
                    ->date(),
                Tables\Columns\TextColumn::make('city'),
            ])
            ->filters([
                //
                Tables\Filters\SelectFilter::make('city')
                    ->options([
                        'nicosia' => 'Nicosia',
                        'famagusta' => 'Famagusta',
                        'guzelyurt' => 'Guzelyurt',
                        'kyrenia' => 'Kyrenia',
                        'lefke' => 'Lefke',
                        'other'=>'Other',
                    ]),
                Tables\Filters\TernaryFilter::make('published')
                    ->boolean()
                    ->trueLabel('Only published jobs')
                    ->falseLabel('Only unpublished jobs')
                    ->native(false),
                Tables\Filters\SelectFilter::make('company_id')
                    ->relationship('company','name')
                    ->label('company'),
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
            ApplicationsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWorks::route('/'),
            'create' => Pages\CreateWork::route('/create'),
            'edit' => Pages\EditWork::route('/{record}/edit'),
        ];
    }
}
