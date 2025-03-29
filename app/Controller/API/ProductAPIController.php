<?php
namespace Phong\Controller\API;
use PDO;
use Phong\Model\Product;

class ProductAPIController
{
    private $product;

    public function __construct(PDO $db)
    {
        $this->product = new Product($db);
    }

    public function getAll()
    {
        try {
            $products = $this->product->getAll();
            return json_encode([
                'status' => 'success',
                'data' => $products
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
            $product = $this->product->getById($id);
            if (!$product) {
                return json_encode([
                    'status' => 'error',
                    'message' => 'Không tìm thấy sản phẩm'
                ]);
            }
            return json_encode([
                'status' => 'success',
                'data' => $product
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
            
            if (!isset($data['name']) || !isset($data['price']) || !isset($data['idCategory'])) {
                return json_encode([
                    'status' => 'error',
                    'message' => 'Thiếu thông tin bắt buộc'
                ]);
            }

            $result = $this->product->create(
                $data['idCategory'],
                $data['name'],
                isset($data['description']) ? $data['description'] : '',
                $data['price'],
                isset($data['imageUrl']) ? $data['imageUrl'] : '',
                isset($data['isDeleted']) ? $data['isDeleted'] : false
            );

            if ($result) {
                return json_encode([
                    'status' => 'success',
                    'message' => 'Tạo sản phẩm thành công'
                ]);
            }

            return json_encode([
                'status' => 'error',
                'message' => 'Không thể tạo sản phẩm'
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
            
            if (!isset($data['name']) || !isset($data['price']) || !isset($data['idCategory'])) {
                return json_encode([
                    'status' => 'error',
                    'message' => 'Thiếu thông tin bắt buộc'
                ]);
            }

            $result = $this->product->update(
                $id,
                $data['idCategory'],
                $data['name'],
                isset($data['description']) ? $data['description'] : '',
                $data['price'],
                isset($data['imageUrl']) ? $data['imageUrl'] : '',
                isset($data['isDeleted']) ? $data['isDeleted'] : false
            );

            if ($result) {
                return json_encode([
                    'status' => 'success',
                    'message' => 'Cập nhật sản phẩm thành công'
                ]);
            }

            return json_encode([
                'status' => 'error',
                'message' => 'Không thể cập nhật sản phẩm'
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
            $result = $this->product->delete($id);

            if ($result) {
                return json_encode([
                    'status' => 'success',
                    'message' => 'Xóa sản phẩm thành công'
                ]);
            }

            return json_encode([
                'status' => 'error',
                'message' => 'Không thể xóa sản phẩm'
            ]);
        } catch (\Exception $e) {
            return json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function getCategories()
    {
        try {
            $categories = $this->product->getCategories();
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
} 