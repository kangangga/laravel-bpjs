<?php

namespace Kangangga\Bpjs;

use Config;
use Kangangga\Bpjs\Bpjs;
use Kangangga\Bpjs\Api\Utils;
use Kangangga\Bpjs\Api\BaseApi;
use Kangangga\Bpjs\Api\Request;
use Spatie\LaravelPackageTools\Package;
use Kangangga\Bpjs\Commands\BpjsCommand;
use Illuminate\Contracts\Foundation\Application;
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
        $this->app->bind(Request::class, function (Application $app) {
            return new Request($app->make(Utils::class));
        });

        $this->app->bind(BaseApi::class, function (Application $app) {
            return new BaseApi($app->make(Request::class));
        });

        $this->app->singleton('bpjs', function (Application $app) {
            return new Bpjs($app);
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
