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
    
    // Method mới: render với layout
    protected function render($view, $data = [], $layout = 'layouts/master')
    {
        // Lấy nội dung view
        $viewPath = '../../app/views/' . $view . '.php';
        if (!file_exists($viewPath)) {
            die('View không tồn tại: ' . $view);
        }
        
        ob_start();
        extract($data);
        require_once $viewPath;
        $content = ob_get_clean();
        
        // Load layout
        $layoutPath = '../../app/views/' . $layout . '.php';
        if (!file_exists($layoutPath)) {
            die('Layout không tồn tại: ' . $layout);
        }
        
        require_once $layoutPath;
    }
    
    protected function redirect($url)
    {
        header('Location: ' . BASE_URL . $url);
        exit();
    }
}
?>