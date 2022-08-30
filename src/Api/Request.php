<?php

namespace Kangangga\Bpjs\Api;

use \Illuminate\Http\Client\Factory;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\PendingRequest;
use LZCompressor\LZString;


class Request
{
    public Utils $utils;

    public PendingRequest $http;

    protected ?string $token = null;

    protected string $base_url;

    protected string $username;

    protected string $password;

    protected ?string $user_key;

    protected ?string $secret_key;

    protected ?int $consumer_id;

    protected $signature;

    protected $timestamp;

    protected $authorization;


    public function __construct(Utils $utils)
    {
        $this->utils = $utils;
    }

    public function getHeaders($otherHeaders = [])
    {
        $headers = collect([]);

        if (isset($this->consumer_id))
            $headers->put('X-cons-id', $this->consumer_id);
        if (isset($this->signature))
            $headers->put('X-signature', $this->signature);

        if (isset($this->timestamp))
            $headers->put('X-timestamp', $this->timestamp);

        if (isset($this->authorization))
            $headers->put('X-authorization', "Basic {$this->authorization}");

        if (isset($this->user_key))
            $headers->put('user_key', $this->user_key);

        $headers->merge($otherHeaders);

        return $headers->toArray();
    }

    public function init($http)
    {
        $this->timestamp = $this->utils->getTimestamp();

        $this->authorization = base64_encode("{$this->username}:{$this->password}:095");

        $this->signature = $this->utils->createSignature($this->consumer_id, $this->secret_key);

        $this->http = $http->withHeaders($this->getHeaders());
    }

    /**
     * Get the value of token
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set the value of token
     *
     * @return  self
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Get the value of base_url
     */
    public function getBaseUrl()
    {
        return $this->base_url;
    }

    /**
     * Set the value of base_url
     *
     * @return  self
     */
    public function setBaseUrl($base_url)
    {
        $this->base_url = $base_url;

        return $this;
    }

    /**
     * Get the value of username
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set the value of username
     *
     * @return  self
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get the value of password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Set the value of consumer_id
     *
     * @return  self
     */
    public function setConsumerId($consumer_id)
    {
        $this->consumer_id = $consumer_id;

        return $this;
    }

    /**
     * Set the value of user_key
     *
     * @return  self
     */
    public function setUserKey($user_key)
    {
        $this->user_key = $user_key;

        return $this;
    }

    /**
     * Set the value of secret_key
     *
     * @return  self
     */
    public function setSecretKey($secret_key)
    {
        $this->secret_key = $secret_key;

        return $this;
    }

    /**
     * Get the value of consumer_id
     */
    public function getConsumerId()
    {
        return $this->consumer_id;
    }

    /**
     * Get the value of timestamp
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Get the value of authorization
     */
    public function getAuthorization()
    {
        return $this->authorization;
    }

    /**
     * Get the value of secret_key
     */
    public function getSecretKey()
    {
        return $this->secret_key;
    }

    public function getKey()
    {
        return $this->getConsumerId() . $this->getSecretKey() . $this->getTimestamp();
    }
}
