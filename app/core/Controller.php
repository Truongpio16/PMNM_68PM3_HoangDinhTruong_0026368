<?php
// app/core/Controller.php

class Controller
{
    protected function view($view, $data = [])
    {
        $viewPath = '../../app/views/' . $view . '.php';
        if (file_exists($viewPath)) {
            extract($data);
            require_once $viewPath;
        } else {
            die('View không tồn tại: ' . $view);
        }
    }
    
    protected function redirect($url)
    {
        header('Location: ' . BASE_URL . $url);
        exit();
    }
}
?>