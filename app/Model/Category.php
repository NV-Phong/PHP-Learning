<?php
namespace Phong\Model;
use PDO;

class Category
{
   private $conn;
   private $table = "CATEGORY";

   public function __construct($db)
   {
      $this->conn = $db;
   }

   public function create($name, $description, $isDeleted)
   {
      $sql = "INSERT INTO {$this->table} (IDCategory, CategoryName, CategoryDescription, IsDeleted) 
              VALUES (UUID(), :name, :description, :isDeleted)";
      $stmt = $this->conn->prepare($sql);
      $stmt->bindParam(":name", $name);
      $stmt->bindParam(":description", $description);
      $stmt->bindParam(":isDeleted", $isDeleted, PDO::PARAM_BOOL);
      return $stmt->execute();
   }

   public function getAll()
   {
      $sql = "SELECT * FROM {$this->table} WHERE IsDeleted = 0";
      $stmt = $this->conn->query($sql);
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
   }

   public function getById($id)
   {
      $sql = "SELECT * FROM {$this->table} WHERE IDCategory = :id AND IsDeleted = 0";
      $stmt = $this->conn->prepare($sql);
      $stmt->bindParam(":id", $id);
      $stmt->execute();
      return $stmt->fetch(PDO::FETCH_ASSOC);
   }

   public function update($id, $name, $description, $isDeleted)
   {
      $sql = "UPDATE {$this->table} 
              SET CategoryName = :name, CategoryDescription = :description, IsDeleted = :isDeleted 
              WHERE IDCategory = :id";
      $stmt = $this->conn->prepare($sql);
      $stmt->bindParam(":id", $id);
      $stmt->bindParam(":name", $name);
      $stmt->bindParam(":description", $description);
      $stmt->bindParam(":isDeleted", $isDeleted, PDO::PARAM_BOOL);
      return $stmt->execute();
   }

   public function delete($id)
   {
      $sql = "UPDATE {$this->table} SET IsDeleted = 1 WHERE IDCategory = :id";
      $stmt = $this->conn->prepare($sql);
      $stmt->bindParam(":id", $id);
      return $stmt->execute();
   }

   // Phương thức mới: Tìm hoặc tạo danh mục mặc định "Không phân loại"
   public function findOrCreateDefaultCategory()
   {
      $defaultName = "Chưa Được Phân Loại";
      $sql = "SELECT IDCategory FROM {$this->table} WHERE CategoryName = :name AND IsDeleted = 0";
      $stmt = $this->conn->prepare($sql);
      $stmt->bindParam(":name", $defaultName);
      $stmt->execute();
      $category = $stmt->fetch(PDO::FETCH_ASSOC);

      if ($category) {
         return $category['IDCategory'];
      }

      // Nếu không tìm thấy, tạo danh mục "Không phân loại"
      $description = "Danh mục mặc định cho các sản phẩm không thuộc danh mục nào";
      $isDeleted = 0;
      $this->create($defaultName, $description, $isDeleted);

      // Lấy lại IDCategory của danh mục vừa tạo
      $stmt = $this->conn->prepare($sql);
      $stmt->bindParam(":name", $defaultName);
      $stmt->execute();
      $category = $stmt->fetch(PDO::FETCH_ASSOC);
      return $category['IDCategory'];
   }
}