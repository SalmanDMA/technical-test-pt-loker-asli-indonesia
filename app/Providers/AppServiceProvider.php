<?php

namespace App\Providers;

use App\Repositories\ApprovalStageRepository;
use App\Repositories\ApprovalStageRepositoryInterface;
use App\Repositories\ApproverRepository;
use App\Repositories\ApproverRepositoryInterface;
use App\Repositories\ExpenseRepository;
use App\Repositories\ExpenseRepositoryInterface;
use App\Services\ApprovalStageService;
use App\Services\ApproverService;
use App\Services\ExpenseService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ApproverRepositoryInterface::class, ApproverRepository::class);
        $this->app->bind(ApprovalStageRepositoryInterface::class, ApprovalStageRepository::class);
        $this->app->bind(ExpenseRepositoryInterface::class, ExpenseRepository::class);
        $this->app->bind(ApproverService::class, ApproverService::class);
        $this->app->bind(ApprovalStageService::class, ApprovalStageService::class);
        $this->app->bind(ExpenseService::class, ExpenseService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
