<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Contracts\View\View;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;

class ListUser extends Component implements HasTable, HasForms
{
    use InteractsWithTable, InteractsWithForms;

    public function table(Table $table): Table
    {
        return $table
            ->query(\App\Models\m_user::query())
            ->columns([
                TextColumn::make('username')->label('Username')->sortable(),
                TextColumn::make('fullname')->label('Nama Lengkap')->sortable(),
                TextColumn::make('role.role_nama')->label('Role')->sortable(),
                TextColumn::make('email')->label('Email')->sortable(),
                TextColumn::make('created_at')->label('Dibuat Pada')->dateTime('d-m-Y H:i:s')->sortable(),
                TextColumn::make('updated_at')->label('Diperbarui Pada')->dateTime('d-m-Y H:i:s')->sortable(),
            ])
            ->defaultSort('username', 'asc')
            ->paginated([3, 5, 10, 20, 'all'])
            ->filters($this->getFilters())
            ->deferLoading();
    }

    public function render(): View
    {
        return view('livewire.list-user', [
            
        ]);
    }

    public function getFilters(): array
    {
        return [
            SelectFilter::make('role')
                ->relationship('role', 'role_nama')
                ->options([
                    'Admin' => 'Admin',
                    'Teknisi' => 'Teknisi',
                    'Sarpras' => 'Sarpras',
                    'Civitas' => 'Civitas',
                ]),
        ];
    }
    
    
}
