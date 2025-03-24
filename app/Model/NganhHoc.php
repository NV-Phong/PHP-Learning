<?php
namespace Phong\Model;
use PDO;

class NganhHoc
{
   private $conn;
   private $table = "NGANHHOC";

   public function __construct($db)
   {
      $this->conn = $db;
   }

   public function create($maNganh, $tenNganh)
   {
      $sql = "INSERT INTO {$this->table} (MaNganh, TenNganh, IsDeleted) 
                VALUES (:maNganh, :tenNganh, 0)";
      $stmt = $this->conn->prepare($sql);
      $stmt->bindParam(":maNganh", $maNganh);
      $stmt->bindParam(":tenNganh", $tenNganh);
      return $stmt->execute();
   }

   public function getAll()
   {
      $sql = "SELECT * FROM {$this->table} WHERE IsDeleted = 0";
      $stmt = $this->conn->query($sql);
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
   }

   public function getById($maNganh)
   {
      $sql = "SELECT * FROM {$this->table} WHERE MaNganh = :maNganh AND IsDeleted = 0";
      $stmt = $this->conn->prepare($sql);
      $stmt->bindParam(":maNganh", $maNganh);
      $stmt->execute();
      return $stmt->fetch(PDO::FETCH_ASSOC);
   }

   public function update($maNganh, $tenNganh, $isDeleted)
   {
      $sql = "UPDATE {$this->table} 
                SET TenNganh = :tenNganh, IsDeleted = :isDeleted 
                WHERE MaNganh = :maNganh";
      $stmt = $this->conn->prepare($sql);
      $stmt->bindParam(":maNganh", $maNganh);
      $stmt->bindParam(":tenNganh", $tenNganh);
      $stmt->bindParam(":isDeleted", $isDeleted, PDO::PARAM_BOOL);
      return $stmt->execute();
   }

   public function delete($maNganh)
   {
      $sql = "UPDATE {$this->table} SET IsDeleted = 1 WHERE MaNganh = :maNganh";
      $stmt = $this->conn->prepare($sql);
      $stmt->bindParam(":maNganh", $maNganh);
      return $stmt->execute();
   }

   // Tìm hoặc tạo ngành học mặc định "Không xác định"
   public function findOrCreateDefaultNganh()
   {
      $defaultName = "Không xác định";
      $sql = "SELECT MaNganh FROM {$this->table} WHERE TenNganh = :tenNganh AND IsDeleted = 0";
      $stmt = $this->conn->prepare($sql);
      $stmt->bindParam(":tenNganh", $defaultName);
      $stmt->execute();
      $nganh = $stmt->fetch(PDO::FETCH_ASSOC);

      if ($nganh) {
         return $nganh['MaNganh'];
      }

      // Nếu không tìm thấy, tạo ngành "Không xác định"
      $maNganh = "KXD";
      $this->create($maNganh, $defaultName);

      // Lấy lại MaNganh của ngành vừa tạo
      $stmt = $this->conn->prepare($sql);
      $stmt->bindParam(":tenNganh", $defaultName);
      $stmt->execute();
      $nganh = $stmt->fetch(PDO::FETCH_ASSOC);
      return $nganh['MaNganh'];
   }
}