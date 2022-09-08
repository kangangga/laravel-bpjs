<?php

namespace Kangangga\Bpjs\Listeners;

use Illuminate\Http\Client\Events\ResponseReceived;

class BpjsResponseReceived
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

    public function handle(ResponseReceived $event)
    {
        app('bpjs-log')->debug(class_basename(self::class), [
            'event' => class_basename($event),
            'endpoint' => $event->request->url(),
        ]);
    }
}
