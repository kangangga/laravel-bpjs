<?php

namespace Kangangga\Bpjs;

use Illuminate\Contracts\Foundation\Application;
use Kangangga\Bpjs\Api\BaseApi;
use Kangangga\Bpjs\Api\Request;
use Kangangga\Bpjs\Api\Utils;
use Kangangga\Bpjs\Commands\BpjsCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class BpjsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-bpjs')
            ->hasConfigFile();
        // ->hasViews()
        // ->hasMigration('create_laravel-bpjs_table')
        // ->hasCommand(BpjsCommand::class);
    }

    public function registeringPackage()
    {
        $this->app->register(BpjsEventServiceProvider::class);

        $this->app->bind(Request::class, function (Application $app) {
            return new Request($app->make(Utils::class));
        });

        $this->app->bind(BaseApi::class, function (Application $app) {
            return new BaseApi($app->make(Request::class));
        });

        $this->app->singleton('bpjs', function (Application $app) {
            return new Bpjs($app);
        });

        $this->app->singleton('bpjs-log', function ($app) {
            return new LogManager($app);
        });
    }

    public function packageRegistered()
    {
    }

    public function bootingPackage()
    {
    }

    public function packageBooted()
    {
    }
}
