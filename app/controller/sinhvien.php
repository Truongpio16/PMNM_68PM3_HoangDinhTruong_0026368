<?php
// app/controllers/SinhVienController.php

require_once '../core/Controller.php';
require_once '../models/SinhVienModel.php';

class SinhVienController extends Controller
{
    private $sinhvienModel;
    
    public function __construct()
    {
        $this->sinhvienModel = new SinhVienModel();
    }
    
    // Hiển thị danh sách sinh viên
    public function index()
    {
        $sinhvienList = $this->sinhvienModel->getAll();
        
        $this->render('sinhvien/index', [
            'sinhvienList' => $sinhvienList
        ]);
    }
    
    // Hiển thị form đăng ký (thêm mới)
    public function dangky()
    {
        $errors = [];
        $oldData = [];
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $mssv = trim($_POST['mssv'] ?? '');
            $hoten = trim($_POST['hoten'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $gioitinh = $_POST['gioitinh'] ?? '';
            $diachi = trim($_POST['diachi'] ?? '');
            $ngaysinh = trim($_POST['ngaysinh'] ?? '');
            $lop = trim($_POST['lop'] ?? '');
            
            $oldData = compact('mssv', 'hoten', 'email', 'gioitinh', 'diachi', 'ngaysinh', 'lop');
            
            // Validate MSSV
            if (!preg_match('/^0.*68$/', $mssv)) {
                $errors['mssv'] = "MSSV phải bắt đầu bằng 0 và kết thúc bằng 68";
            }
            
            // Validate Email
            if (!preg_match('/@st\.huce\.edu\.vn$/', $email)) {
                $errors['email'] = "Email phải có đuôi @st.huce.edu.vn";
            }
            
            // Validate ngày sinh
            $dateParts = explode('/', $ngaysinh);
            if (count($dateParts) != 3) {
                $errors['ngaysinh'] = "Ngày sinh không đúng định dạng dd/mm/yyyy";
            } else {
                if (!checkdate($dateParts[1], $dateParts[0], $dateParts[2])) {
                    $errors['ngaysinh'] = "Ngày sinh không hợp lệ";
                }
            }
            
            if (empty($errors)) {
                // Lưu vào database
                $data = [
                    'mssv' => $mssv,
                    'hoten' => $hoten,
                    'email' => $email,
                    'gioitinh' => $gioitinh,
                    'diachi' => $diachi,
                    'ngaysinh' => $ngaysinh,
                    'lop' => $lop
                ];
                
                if ($this->sinhvienModel->create($data)) {
                    $_SESSION['message'] = 'Đăng ký thành công!';
                    $this->redirect('sinhvientrongchu');
                } else {
                    $errors['database'] = 'Lỗi khi lưu dữ liệu';
                }
            }
        }
        
        $this->render('sinhvien/dangky', [
            'errors' => $errors,
            'data' => $oldData
        ]);
    }
    
    // Hiển thị thông tin sau khi đăng ký
    public function trangchu()
    {
        if (!isset($_SESSION['sinhvien'])) {
            $this->redirect('sinhvien/dangky');
        }
        
        $this->render('sinhvien/trangchu', [
            'sinhvien' => $_SESSION['sinhvien']
        ]);
    }
    public function store()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = [
            'mssv' => $_POST['mssv'],
            'hoten' => $_POST['hoten'],
            'email' => $_POST['email'],
            'gioitinh' => $_POST['gioitinh'],
            'diachi' => $_POST['diachi'],
            'ngaysinh' => $_POST['ngaysinh'],
            'lop' => $_POST['lop']
        ];
        
        $result = $this->sinhvienModel->create($data);
        
        if ($result['success']) {
            $_SESSION['message'] = 'Thêm sinh viên thành công!';
            $this->redirect('sinhvien/index');
        } else {
            $_SESSION['error'] = $result['error'];
            $this->redirect('sinhvien/dangky');
        }
    }
}

}
?>