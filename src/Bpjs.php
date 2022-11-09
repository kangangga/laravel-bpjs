<?php

namespace Kangangga\Bpjs;

use GuzzleHttp\HandlerStack;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Support\Traits\Macroable;
use Kangangga\Bpjs\Api\Antrean;
use Kangangga\Bpjs\Api\Apotek;
use Kangangga\Bpjs\Api\BaseApi;
use Kangangga\Bpjs\Api\Pcare;
use Kangangga\Bpjs\Api\Utils;
use Kangangga\Bpjs\Api\VClaim;
use Kevinrob\GuzzleCache\CacheMiddleware;
use Kevinrob\GuzzleCache\Storage\LaravelCacheStorage;
use Kevinrob\GuzzleCache\Strategy\PrivateCacheStrategy;

class Bpjs
{
    use Macroable;

    /** @var Pcare|VClaim|Antrean|Apotek|BaseApi */
    protected $api;

    protected $config;

    protected $app;

    public $extends = [
        'pcare' => [
            Pcare::class,
        ],
        'vclaim' => [
            VClaim::class,
        ],
        'antrean' => [
            Antrean::class,
        ],
        'apotek' => [
            Apotek::class,
        ],
    ];

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public static function make(): static
    {
        return new static(app());
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

    public static function handlerStack()
    {
        $stack = HandlerStack::create();

        if (Config::get('bpjs.cache') === CacheMiddleware::class) {
            $stack->push(
                new CacheMiddleware(
                    new PrivateCacheStrategy(
                        new LaravelCacheStorage(
                            Cache::store()
                        )
                    )
                ),
                'bpjs-cache-'.Config::get('bpjs.default_auth.consumer_id')
            );
        }

        return $stack;
    }

    protected function registerApi($abstract, $parameters = [])
    {
        /** @var Pcare|VClaim|Antrean|Apotek|BaseApi */
        $this->api = $this->app->make($abstract);

        $this->config = Config::get(
            'bpjs.'.Str::lower(class_basename($abstract))
        );

        if (method_exists($this->api, 'boot')) {
            $this->app->call([$this->api, 'boot'], ['config' => $this->config]);
        }

        if (property_exists($this->api, 'request')) {
            $this->initializationApi($this->api, $this->config);

            $http = Http::baseUrl(Arr::get($this->config, 'base_url'))->withOptions(
                array_merge(
                    Config::get('bpjs.default_options', []),
                    Arr::get($this->config, 'options', []),
                    [
                        'handler' => self::handlerStack(),
                    ]
                ),
            );

            if (method_exists($this->api, 'beforeSending')) {
                $http->beforeSending(function ($client) {
                    return $this->api->beforeSending($client);
                });
            }

            $this->api->request->init($http, $this);

            if (property_exists($this->api, 'extends')) {
                Utils::extendsClass($this->api, [
                    'request' => $this->api->request,
                ]);
            }
        }

        return $this->api;
    }

    protected function initializationApi()
    {
        $this->api->request->setBaseUrl(Arr::get($this->config, 'base_url'));

        $this->api->request->setUsername(
            Arr::get($this->config, 'auth.username', Config::get('bpjs.default_auth.username'))
        );

        $this->api->request->setPassword(
            Arr::get($this->config, 'auth.password', Config::get('bpjs.default_auth.password'))
        );

        $this->api->request->setUserKey(
            Arr::get($this->config, 'auth.user_key', Config::get('bpjs.default_auth.user_key'))
        );

        $this->api->request->setSecretKey(
            Arr::get($this->config, 'auth.secret_key', Config::get('bpjs.default_auth.secret_key'))
        );

        $this->api->request->setConsumerId(
            Arr::get($this->config, 'auth.consumer_id', Config::get('bpjs.default_auth.consumer_id'))
        );
    }
}
