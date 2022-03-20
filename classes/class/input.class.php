<?php

class input extends db
{

    public function post($key = false)
    {
        if (isset($_POST[$key]) AND is_array($_POST[$key])) {
            return $_POST[$key];
        } elseif (isset($_POST[$key])) {
            return parent::quote($_POST[$key]);
        } else {
            return FALSE;
        }
    }

    public function get($key = false)
    {
        if (isset($_GET[$key]) AND is_array($_GET[$key])) {
            return $_GET[$key];
        } elseif (isset($_GET[$key])) {
            return parent::quote($_GET[$key]);
        } else {
            return FALSE;
        }
    }

    public function session($key = false)
    {
        @session_start();
        if (isset($_SESSION[$key]) AND is_array($_SESSION[$key])) {
            return $_SESSION[$key];
        } elseif (isset($_SESSION[$key])) {
            return parent::quote($_SESSION[$key]);
        } else {
            return FALSE;
        }
    }

    public function nav_session($key = false)
    {
        @session_start();
        return $_SESSION[$key];
    }

    public function unset_post($key = false)
    {
        unset($_POST[$key]);
    }

    public function unset_get($key = false)
    {
        unset($_GET[$key]);
    }

    public function unset_session($key = false)
    {
        unset($_SESSION[$key]);
    }

    public function set_session($key, $value)
    {
        @session_start();
        $_SESSION[$key] = $value;
        return true;
    }

    public function set_cookie($key, $value,$dir)
    {
        setcookie($key, $value, time() + (86400 * 30), $dir);
        return true;
    }

    public function cookie($key = false)
    {
        if (isset($_COOKIE[$key]) AND is_array($_COOKIE[$key])) {
            return $_COOKIE[$key];
        } elseif (isset($_COOKIE[$key])) {
            return parent::quote($_COOKIE[$key]);
        } else {
            return FALSE;
        }
    }


    public function unset_cookie($key = false)
    {
        setcookie($key, "", time()-3600);
        unset($_COOKIE[$key]);
        return true;
    }

    public function files($key = false)
    {
        if (isset($_FILES[$key])) {
            return $_FILES[$key];
        } else {
            return FALSE;
        }
    }
}
