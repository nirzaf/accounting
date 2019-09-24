<?php

namespace Modules\Viravira\Providers;

use App\Events\AdminMenuCreated;
use Illuminate\Support\ServiceProvider;
use Illuminate\Console\Scheduling\Schedule;
use Modules\Viravira\Listeners\AdminMenu;

class ViraviraServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerTranslations();
        $this->registerViews();
        $this->registerEvents();
        $this->registerCommands();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/viravira');

        $sourcePath = __DIR__.'/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ]);

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/viravira';
        }, \Config::get('view.paths')), [$sourcePath]), 'viravira');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/viravira');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'viravira');
        } else {
            $this->loadTranslationsFrom(__DIR__ .'/../Resources/lang', 'viravira');
        }
    }

    public function registerEvents()
    {
        $this->app['events']->listen(AdminMenuCreated::class, AdminMenu::class);
    }

    public function registerCommands()
    {
        $this->commands(\Modules\Viravira\Console\Sync::class);

        $this->app->booted(function () {
            app(Schedule::class)->command('viravira:sync')->everyMinute();
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
