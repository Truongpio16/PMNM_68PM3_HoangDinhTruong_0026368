<?php
// app/controllers/home.php

require_once '../core/Controller.php';

class home extends Controller
{
    public function index()
    {
        $isLoggedIn = isset($_SESSION['user']);
        $userName = $isLoggedIn ? $_SESSION['user']['name'] : 'Khách';
        
        $this->view('home/index', [
            'isLoggedIn' => $isLoggedIn,
            'userName' => $userName
        ]);
    }
}
?>