<?php

namespace Kangangga\Bpjs\Api;

use LZCompressor\LZString;

class Utils
{
    public const ENCRYPT_METHOD = 'AES-256-CBC';

    public const OPENSSL_RAW_DATA = 1;

    public static function extendsClass($object, $parameters = [])
    {
        foreach ($object->extends as $property => $abstracts) {
            if (is_array($abstracts)) {
                foreach (array_unique($abstracts, SORT_REGULAR) as $abstract) {
                    $object->{$property} = app($abstract, $parameters);
                }
            } else {
                $object->{$property} = app($abstracts, $parameters);
            }
        }
    }

    public function getTimestamp()
    {
        date_default_timezone_set('UTC');
        $date = now();

        return strval(
            $date->getTimestamp() - strtotime($date->make('1970-01-01 00:00:00')->format('Y-m-d H:i:s'))
        );
    }

    public function createSignature($consumer_id, $secret_key)
    {
        return base64_encode(hash_hmac('sha256', "{$consumer_id}&{$this->getTimestamp()}", $secret_key, true));
    }

    public static function stringDecrypt($key, $string)
    {
        return openssl_decrypt(
            base64_decode($string),
            static::ENCRYPT_METHOD,
            static::keyHash($key),
            static::OPENSSL_RAW_DATA,
            static::ivDecrypt($key)
        );
    }

    public static function decompress($value)
    {
        return LZString::decompressFromEncodedURIComponent($value);
    }

    public static function decodeResponse($key, $response, $associative = true)
    {
        return json_decode(
            static::decompress(
                static::stringDecrypt(
                    $key,
                    $response
                )
            ),
            $associative
        );
    }

    public static function keyHash($key)
    {
        return hex2bin(hash('sha256', $key));
    }

    public static function ivDecrypt($key)
    {
        return substr(hex2bin(hash('sha256', $key)), 0, 16);
    }
}
