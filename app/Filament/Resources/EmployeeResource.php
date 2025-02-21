<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmployeeResource\Pages;
use App\Filament\Resources\EmployeeResource\RelationManagers;
use App\Models\Employee;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;

    protected static ?string $navigationIcon = 'clarity-employee-group-line';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Employee Information')
                    ->description('Fill in the employee information')
                    ->schema([
                        Forms\Components\TextInput::make('dni')
                            ->required()
                            ->unique()
                            ->rule('regex:/^\d{8}$/'),
                        Forms\Components\TextInput::make('names')
                            ->required()
                            ->minLength(3)
                            ->maxLength(255),
                        Forms\Components\TextInput::make('paternal_surname')
                            ->required()
                            ->minLength(3)
                            ->maxLength(255),
                        Forms\Components\TextInput::make('maternal_surname')
                            ->required()
                            ->minLength(3)
                            ->maxLength(255),
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->minLength(3)
                            ->unique()
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('phone')
                            ->tel()
                            ->required()
                            ->rule('regex:/^9\d{8}$/'),
                        Forms\Components\TextInput::make('address')
                            ->required()
                            ->minLength(3)
                            ->maxLength(255),
                        Forms\Components\DatePicker::make('birth_date')
                            ->required(),
                    ])
                    ->columns(2)
                    ->icon('heroicon-o-user'),
                Forms\Components\Section::make('Department and Position')
                    ->description('Select the department and position')
                    ->schema([
                        Forms\Components\Select::make('department_id')
                            ->relationship('department', 'name')
                            ->searchable()
                            ->preload()
                            ->live()
                            ->required(),
                        Forms\Components\Select::make('position_id')
                            ->relationship('position', 'title')
                            ->searchable()
                            ->preload()
                            ->live()
                            ->required(),
                    ])
                    ->columns(2)
                    ->icon('heroicon-o-building-office'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('dni')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('names')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('paternal_surname')
                    ->searchable(),
                Tables\Columns\TextColumn::make('maternal_surname')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->toggleable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->toggleable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('address')
                    ->toggleable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('birth_date')
                    ->toggleable()
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('department.name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('position.title')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageEmployees::route('/'),
        ];
    }
}
