<?php
namespace Phong\Controller;
use Phong\Model\Category;
use PDO;

class CategoryController
{
   private $categoryModel;

   public function __construct(PDO $db)
   {
      $this->categoryModel = new Category($db);
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
            header('Location: /categories');
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
            header('Location: /categories');
            exit;
         } else {
            echo "Có lỗi khi cập nhật danh mục";
         }
      }
      include "../views/category/edit.php";
   }

   public function delete($id)
   {
      if ($this->categoryModel->delete($id)) {
         header('Location: /categories');
         exit;
      } else {
         echo "Có lỗi khi xóa danh mục";
      }
   }
}
