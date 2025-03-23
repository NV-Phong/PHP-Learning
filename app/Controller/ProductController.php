<?php
namespace Phong\Controller;
use Phong\Model\Product;
use PDO;

class ProductController
{
    private $productModel;

    public function __construct(PDO $db)
    {
        $this->productModel = new Product($db);
    }

    public function index()
    {
        $products = $this->productModel->getAll();
        include "../views/product/list.php";
    }

    public function show($id)
    {
        $product = $this->productModel->getById($id);
        if ($product) {
            include "../views/product/show.php";
        } else {
            echo "Không tìm thấy sản phẩm";
        }
    }

    public function create()
    {
        $categories = $this->productModel->getCategories();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idCategory = $_POST['idCategory'] ?? '';
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';
            $price = $_POST['price'] ?? 0;
            $isDeleted = 0;

            // Xử lý upload ảnh
            $imageUrl = null;
            if (isset($_FILES['image'])) {
                error_log("File upload info: " . print_r($_FILES['image'], true));

                if ($_FILES['image']['error'] == UPLOAD_ERR_OK) {
                    $uploadDir = __DIR__ . '/../../public/uploads/';
                    if (!file_exists($uploadDir)) {
                        if (!mkdir($uploadDir, 0777, true)) {
                            echo "Không thể tạo thư mục uploads: " . $uploadDir;
                            return;
                        }
                    }

                    if (!is_writable($uploadDir)) {
                        echo "Thư mục uploads không có quyền ghi: " . $uploadDir;
                        return;
                    }

                    $fileExtension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                    $fileName = uniqid() . '_' . time() . '.' . $fileExtension;
                    $imagePath = $uploadDir . $fileName;

                    error_log("Đường dẫn lưu file: " . $imagePath);
                    error_log("File tạm: " . $_FILES['image']['tmp_name']);

                    if (move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
                        $imageUrl = '/uploads/' . $fileName;
                        error_log("Image URL: " . $imageUrl);
                    } else {
                        $error = error_get_last();
                        echo "Lỗi khi upload ảnh: " . ($error['message'] ?? 'Không rõ nguyên nhân');
                        error_log("Lỗi upload: " . ($error['message'] ?? 'Không rõ nguyên nhân'));
                        return;
                    }
                } else {
                    $uploadErrors = [
                        UPLOAD_ERR_INI_SIZE => 'File vượt quá upload_max_filesize trong php.ini',
                        UPLOAD_ERR_FORM_SIZE => 'File vượt quá MAX_FILE_SIZE trong form',
                        UPLOAD_ERR_PARTIAL => 'File chỉ được upload một phần',
                        UPLOAD_ERR_NO_FILE => 'Không có file được upload',
                        UPLOAD_ERR_NO_TMP_DIR => 'Thiếu thư mục tạm',
                        UPLOAD_ERR_CANT_WRITE => 'Không thể ghi file lên disk',
                        UPLOAD_ERR_EXTENSION => 'PHP extension đã dừng upload'
                    ];
                    $errorCode = $_FILES['image']['error'];
                    echo "Lỗi upload: " . ($uploadErrors[$errorCode] ?? 'Lỗi không xác định (code: ' . $errorCode . ')');
                    error_log("Lỗi upload code: " . $errorCode);
                    return;
                }
            } else {
                error_log("Không có file image được gửi từ form");
            }

            if ($this->productModel->create($idCategory, $name, $description, $price, $imageUrl, $isDeleted)) {
                header('Location: /product/list');
                exit;
            } else {
                echo "Có lỗi khi thêm sản phẩm";
            }
        }
        include "../views/product/create.php";
    }

    public function edit($id)
    {
        $product = $this->productModel->getById($id);
        $categories = $this->productModel->getCategories();

        if (!$product) {
            echo "Không tìm thấy sản phẩm";
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idCategory = $_POST['idCategory'] ?? '';
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';
            $price = $_POST['price'] ?? 0;
            $isDeleted = isset($_POST['isDeleted']) ? 1 : 0;

            // Xử lý upload ảnh mới nếu có
            $imageUrl = $product['ImageURL'];
            if (isset($_FILES['image'])) {
                error_log("File upload info (edit): " . print_r($_FILES['image'], true));

                if ($_FILES['image']['error'] == UPLOAD_ERR_OK) {
                    $uploadDir = __DIR__ . '/../../public/uploads/';
                    if (!file_exists($uploadDir)) {
                        if (!mkdir($uploadDir, 0777, true)) {
                            echo "Không thể tạo thư mục uploads: " . $uploadDir;
                            return;
                        }
                    }

                    if (!is_writable($uploadDir)) {
                        echo "Thư mục uploads không có quyền ghi: " . $uploadDir;
                        return;
                    }

                    $fileExtension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                    $fileName = uniqid() . '_' . time() . '.' . $fileExtension;
                    $imagePath = $uploadDir . $fileName;

                    error_log("Đường dẫn lưu file (edit): " . $imagePath);
                    error_log("File tạm (edit): " . $_FILES['image']['tmp_name']);

                    if (move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
                        $imageUrl = '/uploads/' . $fileName;
                        error_log("Image URL (edit): " . $imageUrl);
                    } else {
                        $error = error_get_last();
                        echo "Lỗi khi upload ảnh: " . ($error['message'] ?? 'Không rõ nguyên nhân');
                        error_log("Lỗi upload (edit): " . ($error['message'] ?? 'Không rõ nguyên nhân'));
                        return;
                    }
                } else {
                    $uploadErrors = [
                        UPLOAD_ERR_INI_SIZE => 'File vượt quá upload_max_filesize trong php.ini',
                        UPLOAD_ERR_FORM_SIZE => 'File vượt quá MAX_FILE_SIZE trong form',
                        UPLOAD_ERR_PARTIAL => 'File chỉ được upload một phần',
                        UPLOAD_ERR_NO_FILE => 'Không có file được upload',
                        UPLOAD_ERR_NO_TMP_DIR => 'Thiếu thư mục tạm',
                        UPLOAD_ERR_CANT_WRITE => 'Không thể ghi file lên disk',
                        UPLOAD_ERR_EXTENSION => 'PHP extension đã dừng upload'
                    ];
                    $errorCode = $_FILES['image']['error'];
                    echo "Lỗi upload: " . ($uploadErrors[$errorCode] ?? 'Lỗi không xác định (code: ' . $errorCode . ')');
                    error_log("Lỗi upload code (edit): " . $errorCode);
                    return;
                }
            } else {
                error_log("Không có file image được gửi từ form (edit)");
            }

            if ($this->productModel->update($id, $idCategory, $name, $description, $price, $imageUrl, $isDeleted)) {
                header('Location: /product/list');
                exit;
            } else {
                echo "Có lỗi khi cập nhật sản phẩm";
            }
        }
        include "../views/product/edit.php";
    }

    public function delete($id)
    {
        if ($this->productModel->delete($id)) {
            header('Location: /product/list');
            exit;
        } else {
            echo "Có lỗi khi xóa sản phẩm";
        }
    }
}