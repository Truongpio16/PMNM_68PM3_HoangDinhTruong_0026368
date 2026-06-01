<?php
// app/controllers/sinhvien.php

require_once '../core/Controller.php';
require_once '../models/SinhVienModel.php';

class SinhVienController extends Controller
{
    private $sinhvienModel;
    
    public function __construct()
    {
        $this->sinhvienModel = new SinhVienModel();
    }
    
    public function index()
    {
        // Lấy danh sách sinh viên
        $sinhvienList = $this->sinhvienModel->getAll();
        
        // Hiển thị view
        $this->view('sinhvien/index', [
            'sinhvienList' => $sinhvienList
        ]);
    }
    
    public function dangky()
    {
        // Code đăng ký như cũ
        // ...
    }
    
    public function trangchu()
    {
        // Code trang chủ như cũ
        // ...
    }
}
?>