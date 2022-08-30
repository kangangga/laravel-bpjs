<?php

namespace Kangangga\Bpjs\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Kangangga\Bpjs\Bpjs
 */
class Bpjs extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'bpjs';
    }
}
