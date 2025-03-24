<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? htmlspecialchars($title) : 'Quản lý sinh viên'; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .container { max-width: 1200px; margin: 0 auto; padding: 20px; }
        .navbar { background-color: #2c5282; color: white; padding: 1rem; }
        .navbar a { color: white; margin-right: 1rem; text-decoration: none; }
        .navbar a:hover { text-decoration: underline; }
        .footer { background-color: #e2e8f0; padding: 1rem; text-align: center; margin-top: 2rem; }
        body { background-color: #edf2f7; }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="container flex justify-between items-center">
            <div>
                <a href="/sinhvien/list" class="text-lg font-bold">QUẢN LÝ SINH VIÊN</a>
            </div>
            <div>
                <?php if (isset($_SESSION['user'])): ?>
                    <span>Xin chào, <?= htmlspecialchars($_SESSION['user']['HoTen']) ?> (<?= htmlspecialchars($_SESSION['user']['MaSV']) ?>)</span>
                    <a href="/logout">Đăng xuất</a>
                <?php else: ?>
                    <a href="/login">Đăng nhập</a>
                <?php endif; ?>
                <a href="/sinhvien/list">Danh sách sinh viên</a>
                <a href="/sinhvien/create">Thêm sinh viên</a>
                <!-- <a href="/nganhhoc/list">Danh sách ngành học</a> -->
                <!-- <a href="/nganhhoc/create">Thêm ngành học</a> -->
                <a href="/dangkyhocphan">Đăng ký học phần</a> <!-- Thêm liên kết đến trang đăng ký -->
                <a href="/product/list">Quản lý sản phẩm</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <?php echo $content; ?>
    </div>

    <footer class="footer">
        <p>© 2025 Quản lý sinh viên. All rights reserved.</p>
    </footer>
</body>
</html>