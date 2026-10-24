<?php

namespace App\Filament\Pages;

use App\Models\SecurityLog;
use BackedEnum;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Page;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use UnitEnum;

class SecurityLogs extends Page implements HasTable
{
    use InteractsWithTable;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-shield-exclamation';
    protected static ?string $navigationLabel = 'Security & Error Logs';
    protected static string | UnitEnum | null $navigationGroup = 'System Administration';
    protected static ?string $slug = 'security-logs';

    protected string $view = 'filament.pages.security-logs';

    public function table(Table $table): Table
    {
        return $table
            ->query(SecurityLog::query()->latest())
            ->columns([
                TextColumn::make('id')
                    ->sortable(),
                TextColumn::make('type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'hacking_attempt' => 'danger',
                        'application_error' => 'warning',
                        default => 'info',
                    })
                    ->searchable()
                    ->sortable(),
                TextColumn::make('level')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'critical', 'danger' => 'danger',
                        'warning' => 'warning',
                        default => 'success',
                    })
                    ->sortable(),
                TextColumn::make('user.name')
                    ->label('User')
                    ->default('Guest / Unauthenticated')
                    ->searchable(),
                TextColumn::make('ip_address')
                    ->label('IP Address')
                    ->searchable()
                    ->copyable(),
                TextColumn::make('method')
                    ->badge(),
                TextColumn::make('url')
                    ->limit(40)
                    ->tooltip(fn (TextColumn $column): ?string => $column->getState()),
                TextColumn::make('created_at')
                    ->label('Timestamp')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->options([
                        'hacking_attempt' => 'Hacking Attempt',
                        'application_error' => 'Application Error',
                        'auth_failure' => 'Auth Failure',
                    ]),
                SelectFilter::make('level')
                    ->options([
                        'info' => 'Info',
                        'warning' => 'Warning',
                        'danger' => 'Danger',
                        'critical' => 'Critical',
                    ]),
            ]);
    }
}
