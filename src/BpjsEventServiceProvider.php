<?php

namespace Kangangga\Bpjs;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class BpjsEventServiceProvider extends ServiceProvider
{
    public function boot()
    {
    }

    public function listens()
    {
        return config('bpjs.listen', []);
    }

    public function shouldDiscoverEvents()
    {
        return false;
    }
}
