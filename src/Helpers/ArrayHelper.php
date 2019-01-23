<?php
namespace NaverBooking\Helpers;

class ArrayHelper
{

    public function __construct()
    {
    }

    // Search an array of objects for the given key value pair
    // and return all the matching objects.
    public static function searchForKey($keyName, $value, $array)
    {
        $objs = [];
        foreach ($array as $key => $val) {
            if ($val[$keyName] === $value) {
                array_push($objs, $array[$key]);
            }
        }
        return $objs;
    }

    public static function mapForKey($keyName, $value, $keyMapName, $array)
    {
        $indices = [];

        foreach ($array as $key => $val) {
            if ($val[$keyName] === $value) {
                array_push($indices, $val[$keyMapName]);
            }
        }
        return $indices;
    }

    public static function extract($keyName, $array)
    {
        return array_map(function ($v) use ($keyName) {
            return $v[$keyName];
        }, $array);
    }

    public static function setValuesNullRecursive(&$arr)
    {
        foreach ($arr as $key => &$value) {
            if (is_array($value)) {
                if (count($value) > 0) {
                    self::setValuesNullRecursive($value);
                }
            } else {
                if (isset($value)) {
                    $value = null;
                }
            }
        }
    }

    public static function objectToArray(&$object)
    {return json_decode(json_encode($object, JSON_UNESCAPED_UNICODE), true);}
}
