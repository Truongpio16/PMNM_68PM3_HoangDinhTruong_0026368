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
    
    // ==================== COMMIT 1: PAGING ====================
    // Hiển thị danh sách sinh viên có phân trang
    public function index()
    {
        // Phân trang
        $limit = 5; // Số dòng mỗi trang
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $limit;
        
        // Lấy tổng số bản ghi và danh sách theo trang
        $total = $this->sinhvienModel->getTotalCount();
        $totalPages = ceil($total / $limit);
        $sinhvienList = $this->sinhvienModel->getPaginated($offset, $limit);
        
        $this->render('sinhvien/index', [
            'sinhvienList' => $sinhvienList,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'total' => $total
        ]);
    }
    
    // ==================== COMMIT 2: UPDATE ====================
    // Hiển thị form sửa sinh viên
    public function edit($id)
    {
        $sinhvien = $this->sinhvienModel->getById($id);
        if (!$sinhvien) {
            $_SESSION['error'] = 'Không tìm thấy sinh viên';
            $this->redirect('sinhvien/index');
        }
        
        $this->render('sinhvien/edit', ['sinhvien' => $sinhvien]);
    }
    
    // Xử lý cập nhật sinh viên
    public function update($id)
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
            
            $result = $this->sinhvienModel->update($id, $data);
            
            if ($result['success']) {
                $_SESSION['message'] = 'Cập nhật sinh viên thành công!';
            } else {
                $_SESSION['error'] = $result['error'];
            }
        }
        $this->redirect('sinhvien/index');
    }
    
    // ==================== COMMIT 3: DELETE ====================
    // Xóa sinh viên
    public function delete($id)
    {
        $result = $this->sinhvienModel->delete($id);
        
        if ($result['success']) {
            $_SESSION['message'] = 'Xóa sinh viên thành công!';
        } else {
            $_SESSION['error'] = $result['error'];
        }
        
        $this->redirect('sinhvien/index');
    }
    
    // ==================== CREATE (Thêm mới) ====================
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
                } else {
                    // Chuyển đổi ngày sinh sang Y-m-d
                    $ngaysinh = $dateParts[2] . '-' . $dateParts[1] . '-' . $dateParts[0];
                }
            }
            
            if (empty($errors)) {
                $data = [
                    'mssv' => $mssv,
                    'hoten' => $hoten,
                    'email' => $email,
                    'gioitinh' => $gioitinh,
                    'diachi' => $diachi,
                    'ngaysinh' => $ngaysinh,
                    'lop' => $lop
                ];
                
                $result = $this->sinhvienModel->create($data);
                
                if ($result['success']) {
                    $_SESSION['message'] = 'Thêm sinh viên thành công!';
                    $this->redirect('sinhvien/index');
                } else {
                    $errors['database'] = $result['error'];
                }
            }
        }
        
        $this->render('sinhvien/dangky', [
            'errors' => $errors,
            'data' => $oldData
        ]);
    }
    
    // Xử lý thêm mới (có thể gọi từ dangky hoặc dùng riêng)
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
}
?>