<?php
class beArray {

    public static function get($array, $key, $default = null) {

        return isset($array[$key])? $array[$key] : $default;

    }

    public static function first($array) {

        return array_shift($array);

    }

    public static function lasr($array) {

        return array_pop($array);

    }

    public static function fetch($array) {

        if (is_null($array)) $array = array();
        if (!is_array($array)) $array = array($array);

        return $array;

    }

}