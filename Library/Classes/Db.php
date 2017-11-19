<?php

class Db
{
    /**
     *
     * @var PDO
     */
    protected static $_pdo = null;

    /**
     *
     * @return PDO
     */
    public static function driver()
    {
        return static::$_pdo;
    }

    public static function setDriver(PDO $pdo)
    {
        static::$_pdo = $pdo;
    }
}