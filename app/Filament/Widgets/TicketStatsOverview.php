<?php

namespace App\Filament\Widgets;

use App\Models\Ticket;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class TicketStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        // Zoptymalizowane zapytanie, aby pobrać otwarte zgłoszenia pogrupowane według priorytetu
        $openTicketsByPriority = Ticket::where('status', '!=', 'zamknięte')
            ->select('priority', DB::raw('count(*) as total'))
            ->groupBy('priority')
            ->pluck('total', 'priority');

        $highPriorityCount = $openTicketsByPriority->get('wysoki', 0);
        $mediumPriorityCount = $openTicketsByPriority->get('średni', 0);
        $lowPriorityCount = $openTicketsByPriority->get('niski', 0);
        $allOpenCount = $highPriorityCount + $mediumPriorityCount + $lowPriorityCount;

        return [
            Stat::make('Wszystkie otwarte zgłoszenia', $allOpenCount)
                ->description("Wysoki: {$highPriorityCount} | Średni: {$mediumPriorityCount} | Niski: {$lowPriorityCount}")
                ->descriptionIcon('heroicon-m-ticket')
                ->color('warning'),
            Stat::make('Zamknięte zgłoszenia (30 dni)', Ticket::where('status', 'zamknięte')->where('updated_at', '>=', now()->subDays(30))->count())
                ->description('Zgłoszenia rozwiązane w ciągu ostatnich 30 dni')
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('success'),
            Stat::make('Zgłoszenia o wysokim priorytecie', $highPriorityCount)
                ->description('Najbardziej pilne problemy')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color('danger'),
        ];
    }
}
