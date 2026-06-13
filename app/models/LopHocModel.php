<?php
// app/models/LopHocModel.php

require_once '../core/Database.php';

class LopHocModel
{
    private $db;
    
    public function __construct()
    {
        $this->db = new Database();
    }
    
    // Lấy tất cả lớp học
    public function getAll()
    {
        $sql = "SELECT * FROM lophoc ORDER BY id DESC";
        return $this->db->fetchAll($sql);
    }
    
    // Lấy lớp học theo ID
    public function getById($id)
    {
        $sql = "SELECT * FROM lophoc WHERE id = :id";
        return $this->db->fetchOne($sql, ['id' => $id]);
    }
    
    // Lấy lớp học theo mã lớp
    public function getByMalop($malop)
    {
        $sql = "SELECT * FROM lophoc WHERE malop = :malop";
        return $this->db->fetchOne($sql, ['malop' => $malop]);
    }
    
    // Thêm lớp học
    public function create($data)
    {
        // Kiểm tra mã lớp đã tồn tại chưa
        $existing = $this->getByMalop($data['malop']);
        if ($existing) {
            return ['success' => false, 'error' => 'Mã lớp đã tồn tại!'];
        }
        
        $sql = "INSERT INTO lophoc (malop, tenlop, khoahoc, siso) 
                VALUES (:malop, :tenlop, :khoahoc, :siso)";
        
        $result = $this->db->execute($sql, $data);
        
        if ($result) {
            return ['success' => true, 'id' => $this->db->getConnection()->lastInsertId()];
        }
        return ['success' => false, 'error' => 'Lỗi khi thêm lớp học'];
    }
    
    // Cập nhật lớp học
    public function update($id, $data)
    {
        $sql = "UPDATE lophoc SET malop=:malop, tenlop=:tenlop, khoahoc=:khoahoc, siso=:siso 
                WHERE id=:id";
        $data['id'] = $id;
        
        $result = $this->db->execute($sql, $data);
        
        if ($result) {
            return ['success' => true];
        }
        return ['success' => false, 'error' => 'Lỗi khi cập nhật lớp học'];
    }
    
    // Xóa lớp học
    public function delete($id)
    {
        $sql = "DELETE FROM lophoc WHERE id = :id";
        $result = $this->db->execute($sql, ['id' => $id]);
        
        if ($result) {
            return ['success' => true];
        }
        return ['success' => false, 'error' => 'Lỗi khi xóa lớp học'];
    }
    
    // Lấy danh sách có phân trang
    public function getPaginated($offset, $limit)
    {
        $sql = "SELECT * FROM lophoc ORDER BY id DESC LIMIT :offset, :limit";
        return $this->db->fetchAll($sql, ['offset' => (int)$offset, 'limit' => (int)$limit]);
    }
    
    // Đếm tổng số bản ghi
    public function getTotalCount()
    {
        $sql = "SELECT COUNT(*) as total FROM lophoc";
        $result = $this->db->fetchOne($sql);
        return $result['total'] ?? 0;
    }
}
?>