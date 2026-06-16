<?php

namespace App\Providers;

use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('projects.partials.sidebar', function ($view): void {
            $workspaceProjects = collect();

            if (Auth::check()) {
                $workspaceProjects = Project::query()
                    ->whereIn('team_id', Auth::user()->teams()->select('teams.id'))
                    ->orderBy('title')
                    ->get();
            }

            $view->with('workspaceProjects', $workspaceProjects);
        });
    }
}
