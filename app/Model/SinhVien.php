<?php
namespace Phong\Model;
use PDO;

class SinhVien
{
    private $conn;
    private $table = "SINHVIEN";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function create($maSV, $hoTen, $gioiTinh, $ngaySinh, $hinh, $maNganh)
    {
        $sql = "INSERT INTO {$this->table} (MaSV, HoTen, GioiTinh, NgaySinh, Hinh, MaNganh, IsDeleted) 
                VALUES (:maSV, :hoTen, :gioiTinh, :ngaySinh, :hinh, :maNganh, 0)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":maSV", $maSV);
        $stmt->bindParam(":hoTen", $hoTen);
        $stmt->bindParam(":gioiTinh", $gioiTinh);
        $stmt->bindParam(":ngaySinh", $ngaySinh);
        $stmt->bindParam(":hinh", $hinh);
        $stmt->bindParam(":maNganh", $maNganh);
        return $stmt->execute();
    }

    public function getAll()
    {
        $sql = "SELECT sv.*, nh.TenNganh 
                FROM {$this->table} sv 
                LEFT JOIN NGANHHOC nh ON sv.MaNganh = nh.MaNganh 
                WHERE sv.IsDeleted = 0 AND (nh.IsDeleted = 0 OR nh.IsDeleted IS NULL)";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($maSV)
    {
        $sql = "SELECT sv.*, nh.TenNganh 
                FROM {$this->table} sv 
                LEFT JOIN NGANHHOC nh ON sv.MaNganh = nh.MaNganh 
                WHERE sv.MaSV = :maSV AND sv.IsDeleted = 0 AND (nh.IsDeleted = 0 OR nh.IsDeleted IS NULL)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":maSV", $maSV);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($maSV, $hoTen, $gioiTinh, $ngaySinh, $hinh, $maNganh, $isDeleted)
    {
        $sql = "UPDATE {$this->table} 
                SET HoTen = :hoTen, GioiTinh = :gioiTinh, NgaySinh = :ngaySinh, 
                    Hinh = :hinh, MaNganh = :maNganh, IsDeleted = :isDeleted 
                WHERE MaSV = :maSV";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":maSV", $maSV);
        $stmt->bindParam(":hoTen", $hoTen);
        $stmt->bindParam(":gioiTinh", $gioiTinh);
        $stmt->bindParam(":ngaySinh", $ngaySinh);
        $stmt->bindParam(":hinh", $hinh);
        $stmt->bindParam(":maNganh", $maNganh);
        $stmt->bindParam(":isDeleted", $isDeleted, PDO::PARAM_BOOL);
        return $stmt->execute();
    }

    public function delete($maSV)
    {
        $sql = "UPDATE {$this->table} SET IsDeleted = 1 WHERE MaSV = :maSV";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":maSV", $maSV);
        return $stmt->execute();
    }

    public function getNganhHoc()
    {
        $sql = "SELECT MaNganh, TenNganh FROM NGANHHOC WHERE IsDeleted = 0";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Phương thức để cập nhật MaNganh cho các sinh viên khi xóa ngành học
    public function updateNganhHoc($oldMaNganh, $newMaNganh)
    {
        $sql = "UPDATE {$this->table} SET MaNganh = :newMaNganh WHERE MaNganh = :oldMaNganh";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":oldMaNganh", $oldMaNganh);
        $stmt->bindParam(":newMaNganh", $newMaNganh);
        return $stmt->execute();
    }
}