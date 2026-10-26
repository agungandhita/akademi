<?php

namespace App\Providers;

use App\Services\Enrollment\EnrollmentInterface;
use App\Services\Enrollment\EnrollmentService;
use App\Services\Module\ModuleInterface;
use App\Services\Module\ModuleService;
use App\Services\Post\PostInterface;
use App\Services\Post\PostService;
use App\Services\Training\TrainingInterface;
use App\Services\Training\TrainingService;
use App\Services\TrainingCategory\TrainingCategoryInterface;
use App\Services\TrainingCategory\TrainingCategoryService;
use App\Services\User\UserInterface;
use App\Services\User\UserService;
use Illuminate\Support\ServiceProvider;

class ServiceRegistryProvider extends ServiceProvider
{
    /**
     * All of the container bindings that should be registered.
     *
     * @var array<class-string, class-string>
     */
    public array $bindings = [
        UserInterface::class => UserService::class,
        TrainingCategoryInterface::class => TrainingCategoryService::class,
        TrainingInterface::class => TrainingService::class,
        PostInterface::class => PostService::class,
        EnrollmentInterface::class => EnrollmentService::class,
        ModuleInterface::class => ModuleService::class,
    ];

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
        //
    }
}
