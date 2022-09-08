<?php

namespace Kangangga\Bpjs\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Client\Events\ConnectionFailed;

class BpjsConnectionFailed
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function handle(ConnectionFailed $event)
    {
        app('bpjs-log')->debug(class_basename(self::class), [
            'event' => class_basename($event),
            'endpoint' => $event->request->url()
        ]);
    }
}
