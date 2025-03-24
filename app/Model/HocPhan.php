<?php
namespace Phong\Model;
use PDO;

class HocPhan
{
   private $db;

   public function __construct(PDO $db)
   {
      $this->db = $db;
   }

   // Lấy tất cả học phần chưa bị xóa
   public function getAll()
   {
      $stmt = $this->db->prepare("SELECT * FROM HOCPHAN WHERE IsDeleted = 0");
      $stmt->execute();
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
   }

   // Lấy học phần theo MaHP
   public function getById($maHP)
   {
      $stmt = $this->db->prepare("SELECT * FROM HOCPHAN WHERE MaHP = ? AND IsDeleted = 0");
      $stmt->execute([$maHP]);
      return $stmt->fetch(PDO::FETCH_ASSOC);
   }

   // Cập nhật số lượng dự kiến
   public function updateSoLuongDuKien($maHP, $soLuong)
   {
      $stmt = $this->db->prepare("UPDATE HOCPHAN SET SoLuongDuKien = ? WHERE MaHP = ?");
      return $stmt->execute([$soLuong, $maHP]);
   }
}