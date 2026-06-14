<?php
// app/controllers/LopHocController.php

require_once '../core/Controller.php';
require_once '../models/LopHocModel.php';

class LopHocController extends Controller
{
    private $lophocModel;
    
    public function __construct()
    {
        $this->lophocModel = new LopHocModel();
    }
    
    // Danh sách lớp học
    public function index()
    {
        $limit = 5;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $limit;
        
        $total = $this->lophocModel->getTotalCount();
        $totalPages = ceil($total / $limit);
        $lophocList = $this->lophocModel->getPaginated($offset, $limit);
        
        $this->render('lophoc/index', [
            'lophocList' => $lophocList,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'total' => $total
        ]);
    }
    
    // Form thêm lớp học
    public function create()
    {
        $this->render('lophoc/create');
    }
    
    // Xử lý thêm lớp học
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'malop' => trim($_POST['malop']),
                'tenlop' => trim($_POST['tenlop']),
                'khoahoc' => trim($_POST['khoahoc']),
                'siso' => (int)$_POST['siso']
            ];
            
            // Validate
            if (empty($data['malop']) || empty($data['tenlop'])) {
                $_SESSION['error'] = 'Vui lòng nhập đầy đủ thông tin!';
                $this->redirect('lophoc/create');
                return;
            }
            
            $result = $this->lophocModel->create($data);
            
            if ($result['success']) {
                $_SESSION['message'] = 'Thêm lớp học thành công!';
                $this->redirect('lophoc/index');
            } else {
                $_SESSION['error'] = $result['error'];
                $this->redirect('lophoc/create');
            }
        }
    }
    
    // Form sửa lớp học
    public function edit($id)
    {
        $lophoc = $this->lophocModel->getById($id);
        if (!$lophoc) {
            $_SESSION['error'] = 'Không tìm thấy lớp học';
            $this->redirect('lophoc/index');
        }
        
        $this->render('lophoc/edit', ['lophoc' => $lophoc]);
    }
    
    // Xử lý cập nhật
    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'malop' => trim($_POST['malop']),
                'tenlop' => trim($_POST['tenlop']),
                'khoahoc' => trim($_POST['khoahoc']),
                'siso' => (int)$_POST['siso']
            ];
            
            $result = $this->lophocModel->update($id, $data);
            
            if ($result['success']) {
                $_SESSION['message'] = 'Cập nhật lớp học thành công!';
            } else {
                $_SESSION['error'] = $result['error'];
            }
        }
        $this->redirect('lophoc/index');
    }
    
    // Xóa lớp học
    public function delete($id)
    {
        $result = $this->lophocModel->delete($id);
        
        if ($result['success']) {
            $_SESSION['message'] = 'Xóa lớp học thành công!';
        } else {
            $_SESSION['error'] = $result['error'];
        }
        
        $this->redirect('lophoc/index');
    }
}
?>