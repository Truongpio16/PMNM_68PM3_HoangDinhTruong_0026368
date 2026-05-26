<?php
// app/models/SinhVienModel.php

require_once '../../app/core/Database.php';

class SinhVienModel
{
    private $db;
    
    public function __construct()
    {
        $this->db = new Database();
    }
    
    public function getAll()
    {
        $sql = "SELECT * FROM sinhvien ORDER BY id DESC";
        return $this->db->fetchAll($sql);
    }
    
    public function getById($id)
    {
        $sql = "SELECT * FROM sinhvien WHERE id = :id";
        return $this->db->fetchOne($sql, ['id' => $id]);
    }
    
    public function create($data)
    {
        $sql = "INSERT INTO sinhvien (mssv, hoten, email, gioitinh, diachi, ngaysinh, lop) 
                VALUES (:mssv, :hoten, :email, :gioitinh, :diachi, :ngaysinh, :lop)";
        return $this->db->execute($sql, $data);
    }
    
    public function update($id, $data)
    {
        $sql = "UPDATE sinhvien SET mssv=:mssv, hoten=:hoten, email=:email, 
                gioitinh=:gioitinh, diachi=:diachi, ngaysinh=:ngaysinh, lop=:lop 
                WHERE id=:id";
        $data['id'] = $id;
        return $this->db->execute($sql, $data);
    }
    
    public function delete($id)
    {
        $sql = "DELETE FROM sinhvien WHERE id = :id";
        return $this->db->execute($sql, ['id' => $id]);
    }
}
?>