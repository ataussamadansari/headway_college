<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Course;
use App\Models\Session;
use App\Models\Student;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StudentStatsOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $totalStudents = Student::count();
        $activeCourses = Course::where('is_active', true)->count();
        $totalSeats = Course::where('is_active', true)->sum('total_seats');
        $activeSessions = Session::where('is_active', true)->count();
        $thisMonthStudents = Student::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        return [
            Stat::make('Total Students', number_format($totalStudents))
                ->description("{$thisMonthStudents} registered this month")
                ->descriptionIcon('heroicon-m-user-group')
                ->color('primary'),

            Stat::make('Active Courses', "{$activeCourses}")
                ->description("{$totalSeats} total approved seats")
                ->descriptionIcon('heroicon-m-academic-cap')
                ->color('success'),

            Stat::make('Active Sessions', "{$activeSessions}")
                ->description('Current academic cycles')
                ->descriptionIcon('heroicon-m-calendar-days')
                ->color('info'),
        ];
    }
}
