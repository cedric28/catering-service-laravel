<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\View;
use App\TaskStaffNotification;
use App\TaskNotification;
use Carbon\Carbon;
use Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (\App::environment([
            'staging',
            'production',
        ])) {
            \URL::forceScheme('https');
        }

        View::composer(['*', 'partials.header'], function ($view) {
            if (Auth::check()) {
                $job_type_id = auth()->user()->job_type_id;
                if ($job_type_id == 2) {
                    $notification = TaskStaffNotification::where([
                        ['user_id', '=', \Auth::user()->id],
                        ['is_read', '=', 0]
                    ])->get();
                    $view->with('notificationStaff', $notification)
                        ->with('notificationStaffCount', count($notification));
                } else if ($job_type_id == 3 || $job_type_id == 4 || $job_type_id == 5) {
                    $notification = TaskNotification::where([
                        ['user_id', '=', \Auth::user()->id],
                        ['is_read', '=', 0]
                    ])->get();
                    $view->with('notificationStaffing', $notification)
                        ->with('notificationStaffingCount', count($notification));
                }
            }
        });

        Schema::defaultStringLength(191);

        Str::macro('currency', function ($price) {
            return 'P' . number_format($price, 2);
        });

        Str::macro('number_comma', function ($number) {
            return number_format($number);
        });

        Str::macro('date_task_format', function ($task_date) {
            return Carbon::parse($task_date)->format('F d Y');
        });
    }
}
