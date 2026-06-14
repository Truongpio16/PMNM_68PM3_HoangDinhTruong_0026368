<?php
// app/controllers/SinhVienController.php

require_once '../core/Controller.php';
require_once '../models/SinhVienModel.php';
require_once '../models/LopHocModel.php';

class SinhVienController extends Controller
{
    private $sinhvienModel;
    private $lophocModel;
    
    public function __construct()
    {
        $this->sinhvienModel = new SinhVienModel();
        $this->lophocModel = new LopHocModel();
    }
    
    // ==================== COMMIT 1: PAGING ====================
    public function index()
    {
        $limit = 5;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $limit;
        
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
    
    // ==================== COMMIT 3: SEARCH ====================
    public function search()
    {
        $keyword = trim($_GET['keyword'] ?? '');
        $searchBy = $_GET['search_by'] ?? 'all';
        
        $limit = 5;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $limit;
        
        if (!empty($keyword)) {
            $total = $this->sinhvienModel->countSearch($keyword, $searchBy);
            $totalPages = ceil($total / $limit);
            $sinhvienList = $this->sinhvienModel->searchPaginated($keyword, $searchBy, $offset, $limit);
            
            $this->render('sinhvien/index', [
                'sinhvienList' => $sinhvienList,
                'currentPage' => $page,
                'totalPages' => $totalPages,
                'total' => $total,
                'keyword' => $keyword,
                'searchBy' => $searchBy,
                'isSearch' => true
            ]);
        } else {
            $this->index();
        }
    }
    
    // ==================== COMMIT 2: UPDATE ====================
    public function edit($id)
    {
        $sinhvien = $this->sinhvienModel->getById($id);
        if (!$sinhvien) {
            $_SESSION['error'] = 'Không tìm thấy sinh viên';
            $this->redirect('sinhvien/index');
        }
        
        $lophocList = $this->lophocModel->getAll();
        
        $this->render('sinhvien/edit', [
            'sinhvien' => $sinhvien,
            'lophocList' => $lophocList
        ]);
    }
    
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
                'malop' => $_POST['malop'] ?? ''
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
    
    // ==================== DELETE ====================
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
    
    // ==================== CREATE ====================
    public function dangky()
    {
        $errors = [];
        $oldData = [];
        
        $lophocList = $this->lophocModel->getAll();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $mssv = trim($_POST['mssv'] ?? '');
            $hoten = trim($_POST['hoten'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $gioitinh = $_POST['gioitinh'] ?? '';
            $diachi = trim($_POST['diachi'] ?? '');
            $ngaysinh = trim($_POST['ngaysinh'] ?? '');
            $malop = $_POST['malop'] ?? '';
            
            $oldData = compact('mssv', 'hoten', 'email', 'gioitinh', 'diachi', 'ngaysinh', 'malop');
            
            if (!preg_match('/^0.*68$/', $mssv)) {
                $errors['mssv'] = "MSSV phải bắt đầu bằng 0 và kết thúc bằng 68";
            }
            
            if (!preg_match('/@st\.huce\.edu\.vn$/', $email)) {
                $errors['email'] = "Email phải có đuôi @st.huce.edu.vn";
            }
            
            $dateParts = explode('/', $ngaysinh);
            if (count($dateParts) != 3) {
                $errors['ngaysinh'] = "Ngày sinh không đúng định dạng dd/mm/yyyy";
            } else {
                if (!checkdate($dateParts[1], $dateParts[0], $dateParts[2])) {
                    $errors['ngaysinh'] = "Ngày sinh không hợp lệ";
                } else {
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
                    'malop' => $malop
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
            'data' => $oldData,
            'lophocList' => $lophocList
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
                'malop' => $_POST['malop'] ?? ''
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