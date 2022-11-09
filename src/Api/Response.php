<?php

namespace Kangangga\Bpjs\Api;

use Illuminate\Support\Arr;
use Illuminate\Support\Traits\Macroable;
use Illuminate\Http\Client\Response as Result;

class Response
{
    use Macroable;

    protected ?int $code;

    protected ?array $data;

    protected mixed $result;

    protected ?string $message;

    protected Request $request;

    protected ?array $response;

    public function __construct(Result $result, Request $request, $validator)
    {
        $this->request = $request;

        $this->result = $result;
        $this->data = Arr::get($this->result, 'metaData');
        $this->code = Arr::get($this->data, 'code');
        $this->message = Arr::get($this->data, 'message');
        $this->parseResponse(Arr::get($this->result, 'response'));

        // Reset timezone
        date_default_timezone_set(
            config('app.timezone', 'Asia/Jakarta')
        );
    }

    public function collect()
    {
        return collect([
            'code' => $this->code,
            'message' => $this->message,
            'response' => $this->response,
        ]);
    }

    public function array()
    {
        return $this->collect()->toArray();
    }

    public function json()
    {
        return $this->collect()->toJson();
    }

    public function search(string $value, $key)
    {
        $data = collect(
            Arr::get($this->response, 'list', [])
        )->filter(function ($item) use ($key, $value) {

            if (is_array($key)) {
                return collect($key)->every(function ($k) use ($value, $item) {
                    return \Str::startsWith($item[$k], $value);
                });
            }

            return \Str::startsWith($item[$key], $value);
        })->values();

        return $data;
    }

    /**
     * Get the value of response
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * Get the value of message
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Get the value of code
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Get the value of result
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * Get the value of data
     */
    public function getMetaData()
    {
        return $this->data;
    }

    /**
     * Get the value of request
     */
    public function getRequest()
    {
        return $this->request;
    }

    private function parseResponse($response)
    {
        if (is_array($response)) {
            $this->response = $response;
        } else {
            $this->response = Utils::decodeResponse(
                $this->request->getKey(),
                $response
            ) ?? [];
        }
    }
}
