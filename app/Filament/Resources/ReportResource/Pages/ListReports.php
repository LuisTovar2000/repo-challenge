<?php

namespace App\Filament\Resources\ReportResource\Pages;

use App\Filament\Resources\ReportResource;
use Filament\Actions;
use App\Models\Sale;
use App\Models\Report;
use Filament\Resources\Pages\ListRecords;

use Filament\Pages\Actions\CreateAction;
use Carbon\Carbon;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class ListReports extends ListRecords
{
    protected static string $resource = ReportResource::class;

    // protected function getHeaderActions(): array
    // {
    //     return [
    //         Actions\CreateAction::make(),
    //     ];
    // }

    protected function getHeaderActions(): array
    {
        return [
            // Acción personalizada que redirige a la página de creación personalizada
            Actions\CreateAction::make('Crear Informe')
                ->url('/admin/generate-reports')
                ->color('primary'),
        ];
    }

    protected function authorizeAccess(): void
    {
        // Solo los usuarios con el rol 'admin' pueden acceder a esta página
        abort_unless(Auth::user()->hasRole('admin'), 403);
    }

}
