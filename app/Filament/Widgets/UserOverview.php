<?php

namespace App\Filament\Widgets;

use App\Models\User;
use App\Models\Work;
use App\Models\Company;
use App\Models\Application;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class UserOverview extends BaseWidget
{
    protected static ?int $sort = 2;
    protected function getStats(): array
    {
        return [
            Stat::make('Users', User::count())
                ->description('Active users')
                ->descriptionIcon('heroicon-o-user-group'),
            Stat::make('Jobs', Work::count())
                ->description('Jobs')
                ->descriptionIcon('heroicon-o-briefcase'),
            Stat::make('Companies', Company::count())
                ->description('Companies')
                ->descriptionIcon('heroicon-o-building-office'),
            Stat::make('Applications', Application::count())
                ->description('Applications')
                ->descriptionIcon('heroicon-o-rocket-launch'),
                
                            
            //

        ];
    }
}
