<?php
namespace Phong\Model;
use PDO;

class Product
{
    private $conn;
    private $table = "PRODUCT";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function create($idCategory, $name, $description, $price, $imageUrl, $isDeleted)
    {
        $sql = "INSERT INTO {$this->table} (IDProduct, IDCategory, ProductName, ProductDescription, Price, ImageURL, IsDeleted) 
                VALUES (UUID(), :idCategory, :name, :description, :price, :imageUrl, :isDeleted)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":idCategory", $idCategory);
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":description", $description);
        $stmt->bindParam(":price", $price, PDO::PARAM_STR);
        $stmt->bindParam(":imageUrl", $imageUrl);
        $stmt->bindParam(":isDeleted", $isDeleted, PDO::PARAM_BOOL);
        return $stmt->execute();
    }

    public function getAll()
    {
        $sql = "SELECT p.*, c.CategoryName 
                FROM {$this->table} p 
                LEFT JOIN CATEGORY c ON p.IDCategory = c.IDCategory 
                WHERE p.IsDeleted = 0";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $sql = "SELECT p.*, c.CategoryName 
                FROM {$this->table} p 
                LEFT JOIN CATEGORY c ON p.IDCategory = c.IDCategory 
                WHERE p.IDProduct = :id AND p.IsDeleted = 0";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $idCategory, $name, $description, $price, $imageUrl, $isDeleted)
    {
        $sql = "UPDATE {$this->table} 
                SET IDCategory = :idCategory, ProductName = :name, ProductDescription = :description, 
                    Price = :price, ImageURL = :imageUrl, IsDeleted = :isDeleted 
                WHERE IDProduct = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":idCategory", $idCategory);
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":description", $description);
        $stmt->bindParam(":price", $price, PDO::PARAM_STR);
        $stmt->bindParam(":imageUrl", $imageUrl);
        $stmt->bindParam(":isDeleted", $isDeleted, PDO::PARAM_BOOL);
        return $stmt->execute();
    }

    public function delete($id)
    {
        $sql = "UPDATE {$this->table} SET IsDeleted = 1 WHERE IDProduct = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }

    // Phương thức mới để cập nhật IDCategory cho các sản phẩm
    public function updateCategory($oldCategoryId, $newCategoryId)
    {
        $sql = "UPDATE {$this->table} SET IDCategory = :newCategoryId WHERE IDCategory = :oldCategoryId";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":oldCategoryId", $oldCategoryId);
        $stmt->bindParam(":newCategoryId", $newCategoryId);
        return $stmt->execute();
    }

    public function getCategories()
    {
        $sql = "SELECT IDCategory, CategoryName FROM CATEGORY WHERE IsDeleted = 0";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}