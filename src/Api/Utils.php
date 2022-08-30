<?php

namespace Kangangga\Bpjs\Api;

use LZCompressor\LZString;

class Utils
{
    public const ENCRYPT_METHOD = 'AES-256-CBC';

    public function getTimestamp()
    {
        date_default_timezone_set('UTC');
        $date = now()->setTimezone('UTC');

        return strval(
            $date->getTimestamp() - strtotime($date->make('1970-01-01 00:00:00')->format('Y-m-d H:i:s'))
        );
    }

    public function createSignature($consumer_id, $secret_key)
    {
        return base64_encode(hash_hmac('sha256', "{$consumer_id}&{$this->getTimestamp()}", $secret_key, true));
    }

    public function stringDecrypt($key, $string)
    {
        $key_hash = hex2bin(hash('sha256', $key));
        $iv = substr(hex2bin(hash('sha256', $key)), 0, 16);
        $output = openssl_decrypt(base64_decode($string), self::ENCRYPT_METHOD, $key_hash, OPENSSL_RAW_DATA, $iv);

        return $output;
    }

    public function decompress($value)
    {
        return LZString::decompressFromEncodedURIComponent($value);
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
