<?php
// app/controllers/sinhvien.php

require_once '../../app/core/Controller.php';
require_once '../../app/middleware/AuthMiddleware.php';

class sinhvien extends Controller
{
    public function dangky()
    {
        AuthMiddleware::check(); // Kiểm tra đã đăng nhập
        
        // Phần code đăng ký như cũ
        // ... (giữ nguyên code đăng ký của bạn)
    }
    
    public function trangchu()
    {
        AuthMiddleware::check(); // Kiểm tra đã đăng nhập
        
        // Phần code hiển thị thông tin
        // ... (giữ nguyên code cũ)
    }
}
?>