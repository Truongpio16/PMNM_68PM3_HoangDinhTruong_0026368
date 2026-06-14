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
    
    // Lấy tất cả sinh viên (kèm tên lớp) - có sort
    public function getAll($sortBy = 'id', $sortOrder = 'DESC')
    {
        $allowedSortFields = ['id', 'mssv', 'hoten', 'malop'];
        $sortBy = in_array($sortBy, $allowedSortFields) ? $sortBy : 'id';
        $sortOrder = strtoupper($sortOrder) === 'ASC' ? 'ASC' : 'DESC';
        
        $sql = "SELECT sv.*, lh.tenlop as tenlop 
                FROM sinhvien sv 
                LEFT JOIN lophoc lh ON sv.malop = lh.malop 
                ORDER BY sv.{$sortBy} {$sortOrder}";
        return $this->db->fetchAll($sql);
    }
    
    // Lấy sinh viên theo ID (kèm tên lớp)
    public function getById($id)
    {
        $sql = "SELECT sv.*, lh.tenlop as tenlop 
                FROM sinhvien sv 
                LEFT JOIN lophoc lh ON sv.malop = lh.malop 
                WHERE sv.id = :id";
        return $this->db->fetchOne($sql, ['id' => $id]);
    }
    
    // Validate MSSV
    public function validateMSSV($mssv)
    {
        return preg_match('/^0.*68$/', $mssv);
    }
    
    // Validate Email
    public function validateEmail($email)
    {
        return preg_match('/@st\.huce\.edu\.vn$/', $email);
    }
    
    // Validate ngày sinh
    public function validateNgaySinh($ngaysinh)
    {
        if (strpos($ngaysinh, '/') !== false) {
            $dateParts = explode('/', $ngaysinh);
            if (count($dateParts) == 3) {
                return checkdate($dateParts[1], $dateParts[0], $dateParts[2]);
            }
            return false;
        }
        $timestamp = strtotime($ngaysinh);
        return $timestamp !== false;
    }
    
    // Chuyển đổi định dạng ngày sinh
    public function convertNgaySinh($ngaysinh)
    {
        if (strpos($ngaysinh, '/') !== false) {
            $dateParts = explode('/', $ngaysinh);
            return $dateParts[2] . '-' . $dateParts[1] . '-' . $dateParts[0];
        }
        return $ngaysinh;
    }
    
    // Thêm sinh viên
    public function create($data)
    {
        if (!$this->validateMSSV($data['mssv'])) {
            return ['success' => false, 'error' => 'MSSV phải bắt đầu bằng 0 và kết thúc bằng 68'];
        }
        
        if (!$this->validateEmail($data['email'])) {
            return ['success' => false, 'error' => 'Email phải có đuôi @st.huce.edu.vn'];
        }
        
        if (!$this->validateNgaySinh($data['ngaysinh'])) {
            return ['success' => false, 'error' => 'Ngày sinh không hợp lệ'];
        }
        
        $data['ngaysinh'] = $this->convertNgaySinh($data['ngaysinh']);
        
        $sql = "INSERT INTO sinhvien (mssv, hoten, email, gioitinh, diachi, ngaysinh, malop) 
                VALUES (:mssv, :hoten, :email, :gioitinh, :diachi, :ngaysinh, :malop)";
        
        $result = $this->db->execute($sql, $data);
        
        if ($result) {
            return ['success' => true, 'id' => $this->db->getConnection()->lastInsertId()];
        }
        return ['success' => false, 'error' => 'Lỗi khi thêm vào database'];
    }
    
    // Cập nhật sinh viên
    public function update($id, $data)
    {
        if (!$this->validateMSSV($data['mssv'])) {
            return ['success' => false, 'error' => 'MSSV phải bắt đầu bằng 0 và kết thúc bằng 68'];
        }
        
        if (!$this->validateEmail($data['email'])) {
            return ['success' => false, 'error' => 'Email phải có đuôi @st.huce.edu.vn'];
        }
        
        if (!empty($data['ngaysinh']) && !$this->validateNgaySinh($data['ngaysinh'])) {
            return ['success' => false, 'error' => 'Ngày sinh không hợp lệ'];
        }
        
        if (!empty($data['ngaysinh'])) {
            $data['ngaysinh'] = $this->convertNgaySinh($data['ngaysinh']);
        }
        
        $sql = "UPDATE sinhvien SET mssv=:mssv, hoten=:hoten, email=:email, 
                gioitinh=:gioitinh, diachi=:diachi, ngaysinh=:ngaysinh, malop=:malop 
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
    
    // Tìm kiếm sinh viên (không phân trang)
    public function search($keyword)
    {
        $sql = "SELECT sv.*, lh.tenlop as tenlop 
                FROM sinhvien sv 
                LEFT JOIN lophoc lh ON sv.malop = lh.malop 
                WHERE sv.mssv LIKE :keyword OR sv.hoten LIKE :keyword OR sv.malop LIKE :keyword 
                ORDER BY sv.id DESC";
        $keyword = "%{$keyword}%";
        return $this->db->fetchAll($sql, ['keyword' => $keyword]);
    }
    
    // ==================== COMMIT 3: SEARCH ====================
    // Tìm kiếm sinh viên có phân trang
    public function searchPaginated($keyword, $searchBy, $offset, $limit, $sortBy = 'id', $sortOrder = 'DESC')
    {
        $allowedSortFields = ['id', 'mssv', 'hoten', 'malop'];
        $sortBy = in_array($sortBy, $allowedSortFields) ? $sortBy : 'id';
        $sortOrder = strtoupper($sortOrder) === 'ASC' ? 'ASC' : 'DESC';
        
        switch ($searchBy) {
            case 'mssv':
                $sql = "SELECT sv.*, lh.tenlop as tenlop 
                        FROM sinhvien sv 
                        LEFT JOIN lophoc lh ON sv.malop = lh.malop 
                        WHERE sv.mssv LIKE :keyword 
                        ORDER BY sv.{$sortBy} {$sortOrder} 
                        LIMIT :offset, :limit";
                break;
            case 'hoten':
                $sql = "SELECT sv.*, lh.tenlop as tenlop 
                        FROM sinhvien sv 
                        LEFT JOIN lophoc lh ON sv.malop = lh.malop 
                        WHERE sv.hoten LIKE :keyword 
                        ORDER BY sv.{$sortBy} {$sortOrder} 
                        LIMIT :offset, :limit";
                break;
            case 'malop':
                $sql = "SELECT sv.*, lh.tenlop as tenlop 
                        FROM sinhvien sv 
                        LEFT JOIN lophoc lh ON sv.malop = lh.malop 
                        WHERE sv.malop LIKE :keyword 
                        ORDER BY sv.{$sortBy} {$sortOrder} 
                        LIMIT :offset, :limit";
                break;
            default:
                $sql = "SELECT sv.*, lh.tenlop as tenlop 
                        FROM sinhvien sv 
                        LEFT JOIN lophoc lh ON sv.malop = lh.malop 
                        WHERE sv.mssv LIKE :keyword 
                           OR sv.hoten LIKE :keyword 
                           OR sv.malop LIKE :keyword 
                        ORDER BY sv.{$sortBy} {$sortOrder} 
                        LIMIT :offset, :limit";
                break;
        }
        
        $keyword = "%{$keyword}%";
        return $this->db->fetchAll($sql, [
            'keyword' => $keyword,
            'offset' => (int)$offset,
            'limit' => (int)$limit
        ]);
    }
    
    // Đếm kết quả tìm kiếm
    public function countSearch($keyword, $searchBy = 'all')
    {
        switch ($searchBy) {
            case 'mssv':
                $sql = "SELECT COUNT(*) as total FROM sinhvien WHERE mssv LIKE :keyword";
                break;
            case 'hoten':
                $sql = "SELECT COUNT(*) as total FROM sinhvien WHERE hoten LIKE :keyword";
                break;
            case 'malop':
                $sql = "SELECT COUNT(*) as total FROM sinhvien WHERE malop LIKE :keyword";
                break;
            default:
                $sql = "SELECT COUNT(*) as total FROM sinhvien 
                        WHERE mssv LIKE :keyword OR hoten LIKE :keyword OR malop LIKE :keyword";
                break;
        }
        
        $keyword = "%{$keyword}%";
        $result = $this->db->fetchOne($sql, ['keyword' => $keyword]);
        return $result['total'] ?? 0;
    }
    
    // Đếm tổng số sinh viên
    public function count()
    {
        $sql = "SELECT COUNT(*) as total FROM sinhvien";
        $result = $this->db->fetchOne($sql);
        return $result['total'] ?? 0;
    }
    
    // ==================== COMMIT 1: PAGING ====================
    // Lấy danh sách có phân trang (có sort)
    public function getPaginated($offset, $limit, $sortBy = 'id', $sortOrder = 'DESC')
    {
        $allowedSortFields = ['id', 'mssv', 'hoten', 'malop'];
        $sortBy = in_array($sortBy, $allowedSortFields) ? $sortBy : 'id';
        $sortOrder = strtoupper($sortOrder) === 'ASC' ? 'ASC' : 'DESC';
        
        $sql = "SELECT sv.*, lh.tenlop as tenlop 
                FROM sinhvien sv 
                LEFT JOIN lophoc lh ON sv.malop = lh.malop 
                ORDER BY sv.{$sortBy} {$sortOrder} 
                LIMIT :offset, :limit";
        return $this->db->fetchAll($sql, [
            'offset' => (int)$offset,
            'limit' => (int)$limit
        ]);
    }
    
    // Lấy tổng số bản ghi
    public function getTotalCount()
    {
        return $this->count();
    }
    
    // Lấy danh sách sinh viên theo mã lớp
    public function getByMalop($malop)
    {
        $sql = "SELECT sv.*, lh.tenlop as tenlop 
                FROM sinhvien sv 
                LEFT JOIN lophoc lh ON sv.malop = lh.malop 
                WHERE sv.malop = :malop 
                ORDER BY sv.id DESC";
        return $this->db->fetchAll($sql, ['malop' => $malop]);
    }
}
?>