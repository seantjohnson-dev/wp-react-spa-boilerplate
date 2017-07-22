<?php

namespace SeanJohn\Utils;

use SeanJohn\Utils\Utils;
use SeanJohn\Utils\Converter;

class Requester
{
    /**
     * Simple curl GET starter. Sets the proper GET curl options for a GET request.
     */
    public static function get($url, $params = [], $headers=['Accept: application/json'], $decode = true)
    {
        $ch = curl_init();
        $url .= Converter::convertArrayToQueryString(Utils::ensureArray($params));
        return self::request($ch, $url, $headers, $decode);
    }

    /**
     * Simple curl POST starter. Sets the proper POST curl options for a POST request.
     */
    public static function post($url, $postFields = [], $headers=['Accept: application/json'], $decode = true)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, Utils::ensureArray($postFields));

        return self::request($ch, $url, $headers, $decode);
    }

    /**
     * Actual request made by Curl.
     */
    protected static function request($ch, $url, $headers=['Accept: application/json'], $decode = true)
    {
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $json = curl_exec($ch);
        curl_close($ch);
        if ($decode) {
            return json_decode($json);
        }

        return $json;
    }
}
