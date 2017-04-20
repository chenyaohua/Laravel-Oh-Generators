<?php

namespace Yish\Generators;

use Illuminate\Support\ServiceProvider;
use Yish\Generators\Commands\PresenterMakeCommand;
use Yish\Generators\Commands\RepositoryMakeCommand;
use Yish\Generators\Commands\ServiceMakeCommand;
use Yish\Generators\Commands\TransformMakeCommand;

class GeneratorsServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    protected $commands = [
        //
    ];

    /**
     * The commands to be registered.
     *
     * @var array
     */
    protected $devCommands = [
        'ServiceMake' => 'command.service.make',
        'RepositoryMake' => 'command.repository.make',
        'TransformMake' => 'command.transform.make',
        'PresenterMake' => 'command.presenter.make',
    ];

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerCommands(array_merge(
            $this->commands, $this->devCommands
        ));
    }

    /**
     * Register the given commands.
     *
     * @param  array $commands
     * @return void
     */
    protected function registerCommands(array $commands)
    {
        foreach (array_keys($commands) as $command) {
            call_user_func_array([$this, "register{$command}Command"], []);
        }

        $this->commands(array_values($commands));
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerServiceMakeCommand()
    {
        $this->app->singleton('command.service.make', function ($app) {
            return new ServiceMakeCommand($app['files']);
        });
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerRepositoryMakeCommand()
    {
        $this->app->singleton('command.repository.make', function ($app) {
            return new RepositoryMakeCommand($app['files']);
        });
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerTransformMakeCommand()
    {
        $this->app->singleton('command.transform.make', function ($app) {
            return new TransformMakeCommand($app['files']);
        });
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerPresenterMakeCommand()
    {
        $this->app->singleton('command.presenter.make', function ($app) {
            return new PresenterMakeCommand($app['files']);
        });
    }
}