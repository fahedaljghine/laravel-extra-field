<?php

namespace Fahedaljghine\ExtraField;

use Illuminate\Support\ServiceProvider;

class ExtraFieldServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->loadMigrationsFrom(__DIR__ . '/../database/migrations/');
        }

        if (!class_exists('CreateExtrasTable')) {
            $timestamp = date('Y_m_d_His', time());

            $this->publishes([
                __DIR__ . '/../database/migrations/create_extras_table.php.stub' => database_path('migrations/' . $timestamp . '_create_extras_table.php'),
            ], 'migrations');
        }

        if (!class_exists('CreateExtraValuesTable')) {
            $timestamp = date('Y_m_d_His', time());

            $this->publishes([
                __DIR__ . '/../database/migrations/create_extra_values_table.php.stub' => database_path('migrations/' . $timestamp . '_create_extra_values_table.php'),
            ], 'migrations');
        }


        $this->publishes([
            __DIR__ . '/../config/extra-field.php' => config_path('extra-field.php'),
        ], 'config');

    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/extra-field.php', 'extra-field');
    }

}
