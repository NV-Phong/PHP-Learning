<?php
namespace Phong\Controller;
use Phong\Model\SinhVien;
use PDO;

class SinhVienController
{
    private $sinhVienModel;

    public function __construct(PDO $db)
    {
        $this->sinhVienModel = new SinhVien($db);
    }

    // Hiển thị danh sách sinh viên
    public function index()
    {
        $sinhViens = $this->sinhVienModel->getAll();
        include "../views/sinhvien/list.php";
    }

    // Xem chi tiết sinh viên
    public function show($maSV)
    {
        $sinhVien = $this->sinhVienModel->getById($maSV);
        if ($sinhVien) {
            include "../views/sinhvien/show.php";
        } else {
            echo "Không tìm thấy sinh viên";
        }
    }

    // Thêm sinh viên mới
    public function create()
    {
        $nganhHoc = $this->sinhVienModel->getNganhHoc();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $maSV = $_POST['maSV'] ?? '';
            $hoTen = $_POST['hoTen'] ?? '';
            $gioiTinh = $_POST['gioiTinh'] ?? '';
            $ngaySinh = $_POST['ngaySinh'] ?? '';
            $maNganh = $_POST['maNganh'] ?? '';

            // Xử lý upload hình ảnh
            $hinh = null;
            if (isset($_FILES['hinh']) && $_FILES['hinh']['error'] == UPLOAD_ERR_OK) {
                $uploadDir = __DIR__ . '/../../public/uploads/';
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                $fileExtension = pathinfo($_FILES['hinh']['name'], PATHINFO_EXTENSION);
                $fileName = uniqid() . '_' . time() . '.' . $fileExtension;
                $imagePath = $uploadDir . $fileName;

                if (move_uploaded_file($_FILES['hinh']['tmp_name'], $imagePath)) {
                    $hinh = '/uploads/' . $fileName;
                }
            }

            if ($this->sinhVienModel->create($maSV, $hoTen, $gioiTinh, $ngaySinh, $hinh, $maNganh)) {
                header('Location: /sinhvien/list');
                exit;
            } else {
                echo "Có lỗi khi thêm sinh viên";
            }
        }
        include "../views/sinhvien/create.php";
    }

    // Sửa thông tin sinh viên
    public function edit($maSV)
    {
        $sinhVien = $this->sinhVienModel->getById($maSV);
        $nganhHoc = $this->sinhVienModel->getNganhHoc();

        if (!$sinhVien) {
            echo "Không tìm thấy sinh viên";
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $hoTen = $_POST['hoTen'] ?? '';
            $gioiTinh = $_POST['gioiTinh'] ?? '';
            $ngaySinh = $_POST['ngaySinh'] ?? '';
            $maNganh = $_POST['maNganh'] ?? '';
            $isDeleted = isset($_POST['isDeleted']) ? 1 : 0;

            // Xử lý upload hình ảnh mới nếu có
            $hinh = $sinhVien['Hinh'];
            if (isset($_FILES['hinh']) && $_FILES['hinh']['error'] == UPLOAD_ERR_OK) {
                $uploadDir = __DIR__ . '/../../public/uploads/';
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                $fileExtension = pathinfo($_FILES['hinh']['name'], PATHINFO_EXTENSION);
                $fileName = uniqid() . '_' . time() . '.' . $fileExtension;
                $imagePath = $uploadDir . $fileName;

                if (move_uploaded_file($_FILES['hinh']['tmp_name'], $imagePath)) {
                    $hinh = '/uploads/' . $fileName;
                }
            }

            if ($this->sinhVienModel->update($maSV, $hoTen, $gioiTinh, $ngaySinh, $hinh, $maNganh, $isDeleted)) {
                header('Location: /sinhvien/list');
                exit;
            } else {
                echo "Có lỗi khi cập nhật sinh viên";
            }
        }
        include "../views/sinhvien/edit.php";
    }

    // Xóa mềm sinh viên
    public function delete($maSV)
    {
        $sinhVien = $this->sinhVienModel->getById($maSV);

        if (!$sinhVien) {
            echo "Không tìm thấy sinh viên";
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->sinhVienModel->delete($maSV)) {
                header('Location: /sinhvien/list');
                exit;
            } else {
                echo "Có lỗi khi xóa sinh viên";
            }
        }

        include "../views/sinhvien/delete.php";
    }
}