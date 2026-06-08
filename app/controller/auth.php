<?php
// app/controllers/auth.php

require_once '../core/Controller.php';
require_once '../models/UserModel.php';
require_once '../middleware/AuthMiddleware.php';

class auth extends Controller
{
    private $userModel;
    
    public function __construct()
    {
        $this->userModel = new UserModel();
    }
    
    public function login()
    {
        AuthMiddleware::guest();
        
        $error = '';
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $password = trim($_POST['password'] ?? '');
            
            if (empty($username) || empty($password)) {
                $error = 'Vui lòng nhập đầy đủ thông tin';
            } else {
                $user = $this->userModel->login($username, $password);
                
                if ($user) {
                    $_SESSION['user'] = $user;
                    $this->redirect('home');
                } else {
                    $error = 'Sai tên đăng nhập hoặc mật khẩu';
                }
            }
        }
        
        $this->view('auth/login', ['error' => $error]);
    }
    
    public function logout()
    {
        session_destroy();
        $this->redirect('home');
    }
}
?>