<?php
namespace Phong\Controller;
use Phong\Model\HocPhan;
use PDO;

class DangKyHocPhanController
{
    private $hocPhanModel;
    private $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
        $this->hocPhanModel = new HocPhan($db);
    }

    public function index()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: /login');
            exit;
        }
        $hocPhans = $this->hocPhanModel->getAll();
        $cart = $_SESSION['cart'] ?? [];
        include "../views/dangkyhocphan/index.php";
    }

    public function addToCart($maHP)
    {
        if (!isset($_SESSION['user'])) {
            header('Location: /login');
            exit;
        }
        $hocPhan = $this->hocPhanModel->getById($maHP);
        if ($hocPhan) {
            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = [];
            }
            if (!in_array($maHP, $_SESSION['cart'])) {
                $_SESSION['cart'][] = $maHP;
            }
        }
        header('Location: /dangkyhocphan');
        exit;
    }

    public function cart()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: /login');
            exit;
        }
        $cart = $_SESSION['cart'] ?? [];
        $hocPhans = [];
        foreach ($cart as $maHP) {
            $hocPhan = $this->hocPhanModel->getById($maHP);
            if ($hocPhan) {
                $hocPhans[] = $hocPhan;
            }
        }
        include "../views/dangkyhocphan/cart.php";
    }

    public function removeFromCart($maHP)
    {
        if (!isset($_SESSION['user'])) {
            header('Location: /login');
            exit;
        }
        if (isset($_SESSION['cart'])) {
            $_SESSION['cart'] = array_filter($_SESSION['cart'], fn($item) => $item !== $maHP);
        }
        header('Location: /dangkyhocphan/cart');
        exit;
    }

    public function clearCart()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: /login');
            exit;
        }
        $_SESSION['cart'] = [];
        header('Location: /dangkyhocphan/cart');
        exit;
    }

    // Hiển thị trang xác nhận
    public function confirm()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: /login');
            exit;
        }

        $cart = $_SESSION['cart'] ?? [];
        if (empty($cart)) {
            header('Location: /dangkyhocphan/cart');
            exit;
        }

        $hocPhans = [];
        foreach ($cart as $maHP) {
            $hocPhan = $this->hocPhanModel->getById($maHP);
            if ($hocPhan) {
                $hocPhans[] = $hocPhan;
            }
        }

        // Lấy thông tin ngành học của sinh viên
        $stmt = $this->db->prepare("SELECT TenNganh FROM NGANHHOC WHERE MaNganh = ?");
        $stmt->execute([$_SESSION['user']['MaNganh']]);
        $nganhHoc = $stmt->fetch(PDO::FETCH_ASSOC);

        include "../views/dangkyhocphan/confirm.php";
    }

    // Lưu đăng ký học phần sau khi xác nhận
    public function save()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: /login');
            exit;
        }

        $cart = $_SESSION['cart'] ?? [];
        if (empty($cart)) {
            header('Location: /dangkyhocphan/cart');
            exit;
        }

        $maSV = $_SESSION['user']['MaSV'];
        $ngayDK = date('Y-m-d');

        $stmt = $this->db->prepare("INSERT INTO DANGKY (NgayDK, MaSV) VALUES (?, ?)");
        $stmt->execute([$ngayDK, $maSV]);
        $maDK = $this->db->lastInsertId();

        foreach ($cart as $maHP) {
            $stmt = $this->db->prepare("INSERT INTO CHITIETDANGKY (MaDK, MaHP) VALUES (?, ?)");
            $stmt->execute([$maDK, $maHP]);

            $hocPhan = $this->hocPhanModel->getById($maHP);
            if ($hocPhan && $hocPhan['SoLuongDuKien'] > 0) {
                $newSoLuong = $hocPhan['SoLuongDuKien'] - 1;
                $this->hocPhanModel->updateSoLuongDuKien($maHP, $newSoLuong);
            }
        }

        $_SESSION['cart'] = [];
        $_SESSION['message'] = "Đăng ký học phần thành công!";
        header('Location: /dangkyhocphan/cart');
        exit;
    }
}