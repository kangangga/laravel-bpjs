<?php

namespace Kangangga\Bpjs;

use Psr\Log\LoggerInterface;

class LogManager implements LoggerInterface
{
    public function driver($driver = null)
    {
        return \Log::build(config('bpjs.logging'));
    }

    public function emergency($message, array $context = []): void
    {
        $this->driver()->emergency($message, $context);
    }

    public function alert($message, array $context = []): void
    {
        $this->driver()->alert($message, $context);
    }

    public function critical($message, array $context = []): void
    {
        $this->driver()->critical($message, $context);
    }

    public function error($message, array $context = []): void
    {
        $this->driver()->error($message, $context);
    }

    public function warning($message, array $context = []): void
    {
        $this->driver()->warning($message, $context);
    }

    public function notice($message, array $context = []): void
    {
        $this->driver()->notice($message, $context);
    }

    public function info($message, array $context = []): void
    {
        $this->driver()->info($message, $context);
    }

    public function debug($message, array $context = []): void
    {
        $this->driver()->debug($message, $context);
    }

    public function log($level, $message, array $context = []): void
    {
        $this->driver()->log($level, $message, $context);
    }

    public function __call($method, $parameters)
    {
        return $this->driver()->$method(...$parameters);
    }
}
