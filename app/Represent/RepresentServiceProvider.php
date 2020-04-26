<?php


namespace App\Represent;

use Illuminate\Support\ServiceProvider;

class RepresentServiceProvider extends ServiceProvider
{
    /**
     * Register Represent services.
     *
     * @return void
     */
    public function register()
    {
        $this->setupAssets();

        $this->app->singleton('represent', function (){
            return new Represent();
        });
    }

    /**
     * Setup package assets.
     *
     * @return void
     */
    protected function setupAssets()
    {
        $this->mergeConfigFrom($config = __DIR__ . '/config/represent.php', 'represent');

        if ($this->app->runningInConsole()) {
//            $this->publishes([$config => config_path('datatables.php')], 'datatables');
        }
    }
}
