<?php

namespace App\Filament\Resources\WorkResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use App\Models\Company;
use Filament\Forms\Form;
use Forms\Components\Tab;
use Filament\Tables\Table;
use Forms\Components\Tabs;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class ApplicationsRelationManager extends RelationManager
{
    protected static string $relationship = 'applications';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('job_application')
                ->tabs([
                    Forms\Components\Tabs\Tab::make('User')
                        ->schema([
                            Forms\Components\Select::make('user_id')
                                ->relationship('user','name')
                                // ->reactive()
                                // ->afterStateUpdated(fn($state, Forms\Set $set )=>
                                //     $set('comapny_id',Company::find($state)?->company_id))
                                ->createOptionForm([
                                    Forms\Components\TextInput::make('name')
                                        ->required()
                                        ->maxLength(255),
                                    Forms\Components\TextInput::make('email')
                                        ->required()
                                        ->label('Email Address')
                                        ->email()
                                        ->live(onBlur: true)
                                        ->unique(),
                                    Forms\Components\TextInput::make('password')            
                                        ->required(),
                                    Forms\Components\TextInput::make('phone')
                                        ->required()
                                        ->tel(),
                                ])
                            
                        ]),
                    Forms\Components\Tabs\Tab::make('Job')
                        ->schema([

                        ]),
                    Forms\Components\Tabs\Tab::make('comapny')
                        ->schema([

                        ]),
                    
                ])->columnSpan('full')
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                Tables\Columns\TextColumn::make('id'),
                Tables\Columns\TextColumn::make('user.name'),
                Tables\Columns\TextColumn::make('work.title'),
                Tables\Columns\TextColumn::make('company.name'),
                Tables\Columns\IconColumn::make('reviewed'),
                Tables\Columns\TextColumn::make('work.city'),
                Tables\Columns\TextColumn::make('applied')
                    ->date(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
