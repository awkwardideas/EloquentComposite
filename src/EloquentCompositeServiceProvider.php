<?php namespace AwkwardIdeas\EloquentComposite;

use AwkwardIdeas\EloquentComposite\Concerns\HasBelongsToManyOn;
use AwkwardIdeas\EloquentComposite\Relations\BelongsToMany;
use Illuminate\Support\ServiceProvider;

class EloquentCompositeServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
    }

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/eloquentcomposite.php', 'eloquentcomposite');

        //$this->app->singleton(Model::class, function ($app) {
        //    return new Model();
        //});
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [Model::class, HasBelongsToManyThrough::class];
    }

}