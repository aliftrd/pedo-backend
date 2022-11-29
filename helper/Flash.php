<?php

namespace Helper;

class Flash
{
    protected static $flash_name = 'pedo_flash';

    public static function setFlash(string $type, string $message)
    {
        if (isset($_SESSION[self::$flash_name][$type])) {
            unset($_SESSION[self::$flash_name][$type]);
        }

        $_SESSION[self::$flash_name][$type] = $message;
    }

    public static function has(string $type)
    {
        return isset($_SESSION[self::$flash_name][$type]);
    }

    public static function display(string $type)
    {
        if (self::has($type)) {
            $message = $_SESSION[self::$flash_name][$type];
            unset($_SESSION[self::$flash_name][$type]);
            return $message;
        }
    }
}
