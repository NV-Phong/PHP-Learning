<?php
namespace Phong\Controller;
use Phong\Model\Category;
use Phong\Model\Product;
use PDO;

class CategoryController
{
   private $categoryModel;
   private $productModel;

   public function __construct(PDO $db)
   {
      $this->categoryModel = new Category($db);
      $this->productModel = new Product($db);
   }

   public function index()
   {
      $categories = $this->categoryModel->getAll();
      include "../views/category/list.php";
   }

   public function show($id)
   {
      $category = $this->categoryModel->getById($id);
      if ($category) {
         include "../views/category/show.php";
      } else {
         echo "Không tìm thấy danh mục";
      }
   }

   public function create()
   {
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
         $name = $_POST['name'] ?? '';
         $description = $_POST['description'] ?? '';
         $isDeleted = 0;

         if ($this->categoryModel->create($name, $description, $isDeleted)) {
            header('Location: /category/list');
            exit;
         } else {
            echo "Có lỗi khi thêm danh mục";
         }
      }
      include "../views/category/create.php";
   }

   public function edit($id)
   {
      $category = $this->categoryModel->getById($id);

      if (!$category) {
         echo "Không tìm thấy danh mục";
         return;
      }

      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
         $name = $_POST['name'] ?? '';
         $description = $_POST['description'] ?? '';
         $isDeleted = isset($_POST['isDeleted']) ? 1 : 0;

         if ($this->categoryModel->update($id, $name, $description, $isDeleted)) {
            header('Location: /category/list');
            exit;
         } else {
            echo "Có lỗi khi cập nhật danh mục";
         }
      }
      include "../views/category/edit.php";
   }

   public function delete($id)
   {
      // Lấy ID của danh mục "Không phân loại"
      $defaultCategoryId = $this->categoryModel->findOrCreateDefaultCategory();

      // Kiểm tra xem danh mục có phải là danh mục mặc định không
      if ($id === $defaultCategoryId) {
         echo "Không thể xóa danh mục mặc định";
         return;
      }

      // Chuyển các sản phẩm sang danh mục mặc định
      $this->productModel->updateCategory($id, $defaultCategoryId);

      // Đánh dấu xóa danh mục
      if ($this->categoryModel->delete($id)) {
         header('Location: /category/list');
         exit;
      } else {
         echo "Có lỗi khi xóa danh mục";
      }
   }
}