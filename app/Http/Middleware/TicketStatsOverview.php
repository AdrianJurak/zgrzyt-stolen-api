<?php

namespace App\Filament\Widgets;

use App\Models\Ticket;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TicketStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $openTicketsQuery = Ticket::where('status', '!=', 'zamknięte');

        return [
            Stat::make('Wszystkie otwarte zgłoszenia', (clone $openTicketsQuery)->count())
                ->description('Wysoki: ' . (clone $openTicketsQuery)->where('priority', 'wysoki')->count() . ' | Średni: ' . (clone $openTicketsQuery)->where('priority', 'średni')->count() . ' | Niski: ' . (clone $openTicketsQuery)->where('priority', 'niski')->count())
                ->descriptionIcon('heroicon-m-ticket')
                ->color('warning'),
            Stat::make('Zamknięte zgłoszenia', Ticket::where('status', 'zamknięte')->count())
                ->description('Zgłoszenia rozwiązane i zarchiwizowane')
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('success'),
            Stat::make('Zgłoszenia o wysokim priorytecie', (clone $openTicketsQuery)->where('priority', 'wysoki')->count())
                ->description('Najbardziej pilne problemy')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color('danger'),
        ];
    }
}