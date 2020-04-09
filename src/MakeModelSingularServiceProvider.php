<?php

namespace Artchik\MakeModelSingular;

use Artchik\MakeModelSingular\Commands\ModelSingularMakeCommand;
use Illuminate\Support\ServiceProvider;

class MakeModelSingularServiceProvider extends ServiceProvider
{
    /**
     * Boot the Service Provider
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                ModelSingularMakeCommand::class
            ]);
        }
    }

}
