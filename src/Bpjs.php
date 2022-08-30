<?php

namespace Kangangga\Bpjs;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Kangangga\Bpjs\Api\Pcare;
use Kangangga\Bpjs\Api\Utils;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Traits\Macroable;
use Illuminate\Contracts\Foundation\Application;
use Kangangga\Bpjs\Api\Antrean;
use Kangangga\Bpjs\Api\Apotek;
use Kangangga\Bpjs\Api\VClaim;

class Bpjs
{
    use Macroable;

    protected $api;

    protected $app;

    protected $bootedCallbacks = [];

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function bootApi($abstract)
    {
    }

    public function registerApi($abstract, $aliases = true)
    {
        $object = $this->app->make($abstract);

        $alias = "bpjs-" . Str::lower(class_basename($abstract));
        $config = Config::get(Str::replace('-', '.', $alias));

        if ($aliases) {
            $this->app->alias($abstract, $alias);
        }

        if (method_exists($object, 'boot')) {
            $this->app->call([$object, 'boot'], ['config' => $config]);
        }

        if (property_exists($object, 'request')) {

            $object->request->setBaseUrl(Arr::get($config, 'base_url'));

            $object->request->setUsername(
                Arr::get($config, 'auth.username', Config::get('bpjs.default_auth.username'))
            );

            $object->request->setPassword(
                Arr::get($config, 'auth.password', Config::get('bpjs.default_auth.password'))
            );

            $object->request->setUserKey(
                Arr::get($config, 'auth.user_key', Config::get('bpjs.default_auth.user_key'))
            );

            $object->request->setSecretKey(
                Arr::get($config, 'auth.secret_key', Config::get('bpjs.default_auth.secret_key'))
            );

            $object->request->setConsumerId(
                Arr::get($config, 'auth.consumer_id', Config::get('bpjs.default_auth.consumer_id'))
            );

            $http = Http::baseUrl(Arr::get($config, 'base_url'))
                ->withOptions(
                    array_merge(
                        Config::get('bpjs.default_options', []),
                        Arr::get($config, 'options', []),
                    ),
                )
                ->beforeSending(function ($client) use ($object) {
                    return $object->beforeSending($client);
                });

            if ($aliases) {
                Http::macro(Str::camel($alias), function () use ($http) {
                    return $http;
                });
            }

            $object->request->init($http);
        }

        return $object;
    }

    public function pcare(): Pcare
    {
        return $this->registerApi(Pcare::class);
    }

    public function vclaim(): VClaim
    {
        return $this->registerApi(VClaim::class);
    }

    public function antrean(): Antrean
    {
        return $this->registerApi(Antrean::class);
    }

    public function apotek(): Apotek
    {
        return $this->registerApi(Apotek::class);
    }
}
