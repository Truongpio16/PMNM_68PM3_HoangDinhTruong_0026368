<?php
// app/models/SinhVienModel.php

require_once '../core/Database.php';

class SinhVienModel
{
    private $db;
    
    public function __construct()
    {
        $this->db = new Database();
    }
    
    // Lấy tất cả sinh viên
    public function getAll()
    {
        $sql = "SELECT * FROM sinhvien ORDER BY id DESC";
        return $this->db->fetchAll($sql);
    }
    
    // Lấy sinh viên theo ID
    public function getById($id)
    {
        $sql = "SELECT * FROM sinhvien WHERE id = :id";
        return $this->db->fetchOne($sql, ['id' => $id]);
    }
    
    // Validate MSSV (bắt đầu bằng 0, kết thúc bằng 68)
    public function validateMSSV($mssv)
    {
        return preg_match('/^0.*68$/', $mssv);
    }
    
    // Validate Email (đuôi @st.huce.edu.vn)
    public function validateEmail($email)
    {
        return preg_match('/@st\.huce\.edu\.vn$/', $email);
    }
    
    // Validate ngày sinh (định dạng dd/mm/yyyy hoặc Y-m-d)
    public function validateNgaySinh($ngaysinh)
    {
        // Nếu là định dạng dd/mm/yyyy
        if (strpos($ngaysinh, '/') !== false) {
            $dateParts = explode('/', $ngaysinh);
            if (count($dateParts) == 3) {
                return checkdate($dateParts[1], $dateParts[0], $dateParts[2]);
            }
            return false;
        }
        
        // Nếu là định dạng Y-m-d (từ input date)
        $timestamp = strtotime($ngaysinh);
        return $timestamp !== false;
    }
    
    // Chuyển đổi định dạng ngày sinh sang Y-m-d cho database
    public function convertNgaySinh($ngaysinh)
    {
        if (strpos($ngaysinh, '/') !== false) {
            $dateParts = explode('/', $ngaysinh);
            return $dateParts[2] . '-' . $dateParts[1] . '-' . $dateParts[0];
        }
        return $ngaysinh;
    }
    
    // Thêm sinh viên (có validation)
    public function create($data)
    {
        // Validation dữ liệu
        if (!$this->validateMSSV($data['mssv'])) {
            return ['success' => false, 'error' => 'MSSV phải bắt đầu bằng 0 và kết thúc bằng 68'];
        }
        
        if (!$this->validateEmail($data['email'])) {
            return ['success' => false, 'error' => 'Email phải có đuôi @st.huce.edu.vn'];
        }
        
        if (!$this->validateNgaySinh($data['ngaysinh'])) {
            return ['success' => false, 'error' => 'Ngày sinh không hợp lệ'];
        }
        
        // Chuyển đổi ngày sinh sang định dạng database
        $data['ngaysinh'] = $this->convertNgaySinh($data['ngaysinh']);
        
        $sql = "INSERT INTO sinhvien (mssv, hoten, email, gioitinh, diachi, ngaysinh, lop) 
                VALUES (:mssv, :hoten, :email, :gioitinh, :diachi, :ngaysinh, :lop)";
        
        $result = $this->db->execute($sql, $data);
        
        if ($result) {
            return ['success' => true, 'id' => $this->db->getConnection()->lastInsertId()];
        }
        return ['success' => false, 'error' => 'Lỗi khi thêm vào database'];
    }
    
    // Cập nhật sinh viên
    public function update($id, $data)
    {
        // Validation dữ liệu
        if (!$this->validateMSSV($data['mssv'])) {
            return ['success' => false, 'error' => 'MSSV phải bắt đầu bằng 0 và kết thúc bằng 68'];
        }
        
        if (!$this->validateEmail($data['email'])) {
            return ['success' => false, 'error' => 'Email phải có đuôi @st.huce.edu.vn'];
        }
        
        if (!empty($data['ngaysinh']) && !$this->validateNgaySinh($data['ngaysinh'])) {
            return ['success' => false, 'error' => 'Ngày sinh không hợp lệ'];
        }
        
        // Chuyển đổi ngày sinh nếu có
        if (!empty($data['ngaysinh'])) {
            $data['ngaysinh'] = $this->convertNgaySinh($data['ngaysinh']);
        }
        
        $sql = "UPDATE sinhvien SET mssv=:mssv, hoten=:hoten, email=:email, 
                gioitinh=:gioitinh, diachi=:diachi, ngaysinh=:ngaysinh, lop=:lop 
                WHERE id=:id";
        $data['id'] = $id;
        
        $result = $this->db->execute($sql, $data);
        
        if ($result) {
            return ['success' => true];
        }
        return ['success' => false, 'error' => 'Lỗi khi cập nhật database'];
    }
    
    // Xóa sinh viên
    public function delete($id)
    {
        $sql = "DELETE FROM sinhvien WHERE id = :id";
        $result = $this->db->execute($sql, ['id' => $id]);
        
        if ($result) {
            return ['success' => true];
        }
        return ['success' => false, 'error' => 'Lỗi khi xóa sinh viên'];
    }
    
    // Tìm kiếm sinh viên theo MSSV hoặc Họ tên
    public function search($keyword)
    {
        $sql = "SELECT * FROM sinhvien WHERE mssv LIKE :keyword OR hoten LIKE :keyword ORDER BY id DESC";
        $keyword = "%{$keyword}%";
        return $this->db->fetchAll($sql, ['keyword' => $keyword]);
    }
    
    // Đếm tổng số sinh viên
    public function count()
    {
        $sql = "SELECT COUNT(*) as total FROM sinhvien";
        $result = $this->db->fetchOne($sql);
        return $result['total'] ?? 0;
    }
    
    // Lấy danh sách có phân trang (THÊM MỚI CHO COMMIT 1)
    public function getPaginated($offset, $limit)
    {
        $sql = "SELECT * FROM sinhvien ORDER BY id DESC LIMIT :offset, :limit";
        return $this->db->fetchAll($sql, ['offset' => (int)$offset, 'limit' => (int)$limit]);
    }
    
    // Lấy tổng số bản ghi (THÊM MỚI CHO COMMIT 1)
    public function getTotalCount()
    {
        return $this->count();
    }
}
?>