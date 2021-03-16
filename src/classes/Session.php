<?php

namespace App\classes;

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

class Session{
    public static  function getSessionData($sessionName)
    {
        if(self::checkSession($sessionName)) {
            return $_SESSION[$sessionName];
        }
        else
            return false;
    }

    public static function setSessionData($sessionName,$sessionValue)
    {
        $_SESSION[$sessionName] = $sessionValue;
    }

    public static  function getFlashData($sessionName)
    {
        if(self::checkSession($sessionName)) {
            $v = $_SESSION[$sessionName];
            unset($_SESSION[$sessionName]);
            return $v;
        }
        else return false;
    }

    public static  function checkSession($sessionName)
    {
        if(isset($_SESSION[$sessionName])) return true;
        else return false;
    }

    public static  function clearSession()
    {
        session_unset();
        return session_destroy();        
    }
}
?>