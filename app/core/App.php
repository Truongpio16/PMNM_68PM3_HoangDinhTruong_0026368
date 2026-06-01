<?php
class App
{
    protected $controller = 'home';
    protected $action = 'index';
    protected $params = [];

    public function __construct()
    {
        $urlProcessed = $this->UrlProcess();
        
        // Xử lý controller
        if (isset($urlProcessed[0])) {
            $controllerName = $urlProcessed[0];
            if (file_exists('../../app/controllers/' . $controllerName . '.php')) {
                $this->controller = $controllerName;
                unset($urlProcessed[0]);
            }
        }
        
        // Load controller
        require_once '../../app/controllers/' . $this->controller . '.php';
        $this->controller = new $this->controller;
        
        // Xử lý action
        if (isset($urlProcessed[1])) {
            if (method_exists($this->controller, $urlProcessed[1])) {
                $this->action = $urlProcessed[1];
                unset($urlProcessed[1]);
            }
        }
        
        // Xử lý params
        $this->params = $urlProcessed ? array_values($urlProcessed) : [];
        
        // Gọi controller và action
        call_user_func_array([$this->controller, $this->action], $this->params);
    }
    
    public function UrlProcess()
    {
        if (isset($_GET['url'])) {
            return explode('/', filter_var(trim($_GET['url'], '/')));
        }
        return [];
    }
}
?>