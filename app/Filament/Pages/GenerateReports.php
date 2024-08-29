<?php

namespace App\Filament\Pages;

use Filament\Forms;
use Filament\Pages\Page;
use App\Models\Sale;
use App\Models\Report;
use Carbon\Carbon;
use Filament\Notifications\Notification;

class GenerateReports extends Page
{
    public $start_date;
    public $end_date;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static string $view = 'filament.pages.generate-reports';

    public static function shouldRegisterNavigation(): bool
    {
        return false; // Esto oculta la página del menú de navegación porque tuve que crear esta pagina aparte ya que desde el recurso principal no se podia acceder bien a la info de la db
    }

    protected function authorizeAccess(): void
    {
        if (auth()->user()->role !== 'admin') {
            abort(403); // Prohibir el acceso si no es administrador
        }
    }

    // Configuración del formulario
    protected function getFormSchema(): array
    {
        return [
            Forms\Components\DatePicker::make('start_date')
                ->label('Fecha de Inicio')
                ->required(),

            Forms\Components\DatePicker::make('end_date')
                ->label('Fecha de Fin')
                ->required(),
        ];
    }

    public function generateReport()
    {
        $this->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);

        // Ajuste para que las fechas seleccionadas se conviertan a UTC
        $startDate = Carbon::parse($this->start_date)->startOfDay()->timezone('UTC');
        $endDate = Carbon::parse($this->end_date)->endOfDay()->timezone('UTC');

        // Obtener ventas en el rango de fechas ajustado
        $sales = Sale::with('product')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();

        if ($sales->isEmpty()) {
            Notification::make()->title('No se encontraron ventas para las fechas seleccionadas.')->warning()->send();
            return;
        }

        // Cálculo de valores
        $totalSales = $sales->sum('total_price');
        $totalCost = $sales->sum(fn ($sale) => $sale->product->manufacturing_cost * $sale->quantity);
        $totalTax = $sales->sum(fn ($sale) => $sale->product->tax * $sale->quantity);

        // Crear el informe
        $report = Report::create([
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'total_sales' => $totalSales,
            'total_cost' => $totalCost,
            'total_tax' => $totalTax,
        ]);

        if ($report) {
            Notification::make()->title('Informe creado exitosamente.')->success()->send();
        } else {
            Notification::make()->title('Error al crear el informe.')->danger()->send();
        }
    }
}
