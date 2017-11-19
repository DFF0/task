<?php

class Registry
{
    static protected $_entries = [];

    static function set($key, $value)
    {
        static::$_entries[$key] = $value;
    }

    static function get($key, $defaultValue = null)
    {
        if (isset(static::$_entries[$key]))
            return static::$_entries[$key];

        return $defaultValue;
    }
}
