<?php
namespace Phong\Controller\API;

use Phong\Model\Category;
use PDO;

class CategoryAPIController
{
    private $category;

    public function __construct(PDO $db)
    {
        $this->category = new Category($db);
    }

    public function getAll()
    {
        try {
            $categories = $this->category->getAll();
            return json_encode([
                'status' => 'success',
                'data' => $categories
            ]);
        } catch (\Exception $e) {
            return json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function getById($id)
    {
        try {
            $category = $this->category->getById($id);
            if (!$category) {
                return json_encode([
                    'status' => 'error',
                    'message' => 'Không tìm thấy danh mục'
                ]);
            }
            return json_encode([
                'status' => 'success',
                'data' => $category
            ]);
        } catch (\Exception $e) {
            return json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function create()
    {
        try {
            $data = json_decode(file_get_contents('php://input'), true);
            
            if (!isset($data['name']) || !isset($data['description'])) {
                return json_encode([
                    'status' => 'error',
                    'message' => 'Thiếu thông tin bắt buộc'
                ]);
            }

            $result = $this->category->create(
                $data['name'],
                $data['description'],
                isset($data['isDeleted']) ? $data['isDeleted'] : false
            );

            if ($result) {
                return json_encode([
                    'status' => 'success',
                    'message' => 'Tạo danh mục thành công'
                ]);
            }

            return json_encode([
                'status' => 'error',
                'message' => 'Không thể tạo danh mục'
            ]);
        } catch (\Exception $e) {
            return json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function update($id)
    {
        try {
            $data = json_decode(file_get_contents('php://input'), true);
            
            if (!isset($data['name']) || !isset($data['description'])) {
                return json_encode([
                    'status' => 'error',
                    'message' => 'Thiếu thông tin bắt buộc'
                ]);
            }

            $result = $this->category->update(
                $id,
                $data['name'],
                $data['description'],
                isset($data['isDeleted']) ? $data['isDeleted'] : false
            );

            if ($result) {
                return json_encode([
                    'status' => 'success',
                    'message' => 'Cập nhật danh mục thành công'
                ]);
            }

            return json_encode([
                'status' => 'error',
                'message' => 'Không thể cập nhật danh mục'
            ]);
        } catch (\Exception $e) {
            return json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function delete($id)
    {
        try {
            $result = $this->category->delete($id);

            if ($result) {
                return json_encode([
                    'status' => 'success',
                    'message' => 'Xóa danh mục thành công'
                ]);
            }

            return json_encode([
                'status' => 'error',
                'message' => 'Không thể xóa danh mục'
            ]);
        } catch (\Exception $e) {
            return json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }
} 