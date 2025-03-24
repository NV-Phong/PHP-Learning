<?php
namespace Phong\Controller;
use PDO;

class AuthController
{
    private $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    // Hiển thị form đăng nhập và xử lý đăng nhập
    public function login()
    {
        // Đảm bảo session đã được khởi tạo
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $maSV = $_POST['maSV'] ?? '';

            // Kiểm tra nếu MaSV rỗng
            if (empty($maSV)) {
                $error = "Vui lòng nhập mã sinh viên!";
            } else {
                // Kiểm tra sinh viên tồn tại
                $stmt = $this->db->prepare("SELECT * FROM SINHVIEN WHERE MaSV = ? AND IsDeleted = 0");
                $stmt->execute([$maSV]);
                $sinhVien = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($sinhVien) {
                    $_SESSION['user'] = $sinhVien;
                    header('Location: /dangkyhocphan');
                    exit;
                } else {
                    $error = "Mã sinh viên không tồn tại hoặc đã bị xóa!";
                }
            }
        }
        include "../views/login.php";
    }

    // Xử lý đăng xuất
    public function logout()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_destroy();
        header('Location: /login');
        exit;
    }
}