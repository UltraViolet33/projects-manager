<?php

namespace App\Core\Helpers;

class Session
{

    public static function init(): void
    {
        if (empty(session_id())) {
            session_start();
        }
    }


    public static function setErrorMsg(string $value): void
    {
        self::set("error", $value);
    }


    public static function getErrorMsg(): string|bool
    {
        return self::get("error");
    }


    public static function set(string $key, string $value): void
    {
        $_SESSION[$key] = $value;
    }


    public static function get(string $key): string|bool
    {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }

        return false;
    }


    public static function unset(string $key): bool
    {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
            return true;
        }

        return false;
    }
}