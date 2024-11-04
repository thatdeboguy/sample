<?php

namespace App\Filament\Widgets;

use Carbon\Carbon;
use App\Models\User;
use Filament\Widgets\ChartWidget;

class Allchart extends ChartWidget
{
    protected static ?string $heading = 'User Registration';
    protected static ?int $sort = 3;


    protected function getData(): array
    {
        $data = $this->getUserspermonth();
        return [
            'datasets' => [
                [
                    'label' => 'Monthly User Registrations',
                    'data' => $data['Userspermonth'],
                    'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
                    'borderColor' => 'rgba(75, 192, 192, 1)',
                    'borderWidth' => 2,
                ],
            ],
            'labels' => $data['months'],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    private function getUserspermonth(): array
    {
        $now = Carbon::now();

        $Userspermonth = [];
        $months = [];

        for ($i = 1; $i <= 12; $i++) {
            $count = User::whereYear('created_at', $now->year)
                         ->whereMonth('created_at', $i)
                         ->count();
            $Userspermonth[] = $count;
            $months[] = Carbon::create()->month($i)->format('M');
        }

        return [
            'Userspermonth' => $Userspermonth,
            'months' => $months,
        ];
    }
}
