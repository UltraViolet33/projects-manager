<?php

declare(strict_types=1);

namespace App\Core\Database;

class Config
{

    private static $instance;
    public static array $dbConfig;
    private static bool $debug = false;

    private function __construct()
    {
        self::$dbConfig['db_name'] = "projects-manager-prod";

        if (self::$debug) {
            self::$dbConfig['db_name'] = "projects-manager-debug";
        }

        self::$dbConfig['db_type'] = "mysql";
        self::$dbConfig['db_host'] = "localhost";
        self::$dbConfig['db_user'] = "root";
        self::$dbConfig['db_password'] = "";
    }


    private static function init(): self
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }


    public static function getValue(string $key): string
    {
        self::init();
        return self::$dbConfig[$key];
    }
}