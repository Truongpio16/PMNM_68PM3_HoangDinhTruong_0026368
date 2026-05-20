<?php
// app/models/UserModel.php

class UserModel
{
    private $users = [
        'admin' => ['username' => 'admin', 'password' => '123456', 'name' => 'Admin', 'role' => 'admin'],
        'truong' => ['username' => 'truong', 'password' => '0026368', 'name' => 'Hoàng Đình Trường', 'role' => 'user']
    ];
    
    public function login($username, $password)
    {
        if (isset($this->users[$username]) && $this->users[$username]['password'] === $password) {
            return $this->users[$username];
        }
        return false;
    }
}
?>