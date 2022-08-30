<?php

namespace Kangangga\Bpjs\Api;

use Arr;
use Illuminate\Http\Client\Response as Result;
use Illuminate\Support\Traits\Macroable;
use LZCompressor\LZString;

class Response
{
    use Macroable;

    protected ?int $code;

    protected ?array $data;

    protected mixed $result;

    protected ?string $message;

    protected Request $request;

    protected ?array $response;

    public function __construct(Result $result, Request $request)
    {
        $this->request = $request;
        $this->result = $result->json();
        $this->data = Arr::get($this->result, 'metaData');
        $this->code = Arr::get($this->data, 'code');
        $this->message = Arr::get($this->data, 'message');

        $this->parseResponse();
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

    private function parseResponse()
    {
        $object = json_decode(
            LZString::decompressFromEncodedURIComponent(
                $this->stringDecrypt(
                    $this->request->getKey(),
                    Arr::get($this->result, 'response')
                )
            ),
            true
        );

        $this->response = $object;
    }

    private function stringDecrypt($key, $string)
    {
        $key_hash = hex2bin(hash('sha256', $key));
        $iv = substr(hex2bin(hash('sha256', $key)), 0, 16);
        $output = openssl_decrypt(base64_decode($string), Utils::ENCRYPT_METHOD, $key_hash, OPENSSL_RAW_DATA, $iv);

        return $output;
    }
}
