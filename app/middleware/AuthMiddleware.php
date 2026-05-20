<?php
// app/middleware/AuthMiddleware.php

class AuthMiddleware
{
    public static function check()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: ' . BASE_URL . 'auth/login');
            exit();
        }
    }
    
    public static function guest()
    {
        if (isset($_SESSION['user'])) {
            header('Location: ' . BASE_URL . 'home');
            exit();
        }
    }
}
?>