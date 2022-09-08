<?php

namespace Kangangga\Bpjs\Listeners;

use Illuminate\Http\Client\Events\RequestSending;

class BpjsRequestSending
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

    public function handle(RequestSending $event)
    {
        app('bpjs-log')->debug(class_basename(self::class), [
            'event' => class_basename($event),
            'endpoint' => $event->request->url(),
        ]);
    }
}
