<?php

namespace App\Filament\Widgets;

use Carbon\Carbon;
use App\Models\Work;
use Filament\Widgets\ChartWidget;

class Jobchart extends ChartWidget
{
    protected static ?string $heading = 'Jobs';
    protected static ?int $sort = 3;

    protected function getData(): array
    {
        $data = $this->getjobsperday();
        return [
            'datasets' => [
                [
                    'label' => 'Created Jobs',
                    'data' => $data['jobsperday'],
                ],
                ],
            'labels' => $data['days'],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    private function getjobsperday(): array
    {

        $now = Carbon::now();

        $jobsperday = [];
        $days = [];

        for($i = 1; $i<=10; $i++){
            $day = $now->copy()->subDays($i);

            $count = Work::whereDate('created_at', $day->toDateString())->count();
            $jobsperday[] = $count;
            $days[] = $day->format('M-d');

        }
        return [
            'jobsperday' =>  array_reverse($jobsperday),
            'days' =>  array_reverse($days),
        ];
    }
}
