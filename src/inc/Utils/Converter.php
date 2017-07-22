<?php

namespace SeanJohn\Utils;

use SeanJohn\Utils\Utils;

class Converter
{
    public static function convertObjectToArray($d)
    {
        if (is_object($d)) {
            $d = get_object_vars($d);
        }

        if (is_array($d)) {
            return array_map(__FUNCTION__, $d);
        } else {
            return $d;
        }
    }

    public static function convertArrayToObject($d)
    {
        if (is_array($d)) {
            return (object) array_map(__FUNCTION__, $d);
        } else {
            return $d;
        }
    }

    public static function convertArrayToQueryString($params = array())
    {
        $qs = '';
        $params = Utils::ensureArray($params);
        $counter = 0;
        foreach ($params as $key => $value) {
            $qs .= ($counter === 0 ? '?' : '&');
            $qs .= $key.'='.$value;
            ++$counter;
        }

        return $qs;
    }

    public static function array_flatten($array) {
      if (!is_array($array)) {
        return false;
      }
      $result = [];
      foreach ($array as $key => $value) {
        if (is_array($value)) {
          $result = array_merge($result, self::array_flatten($value));
        } else {
          $result[$key] = $value;
        }
      }
      return $result;
    }
}
