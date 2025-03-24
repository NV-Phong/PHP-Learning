<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? htmlspecialchars($title) : 'Quản lý sản phẩm'; ?></title>
    <!-- Sử dụng Tailwind CSS từ CDN để làm đẹp giao diện -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Tùy chỉnh thêm nếu cần */
        .container { max-width: 1200px; margin: 0 auto; padding: 20px; }
        .navbar { background-color: #1f2937; color: white; padding: 1rem; }
        .navbar a { color: white; margin-right: 1rem; text-decoration: none; }
        .navbar a:hover { text-decoration: underline; }
        .footer { background-color: #f3f4f6; padding: 1rem; text-align: center; margin-top: 2rem; }
    </style>
</head>
<body class="bg-gray-100">
    <!-- Navigation -->
    <nav class="navbar">
        <div class="container flex justify-between items-center">
            <div>
                <a href="/product/list" class="text-lg font-bold">QUẢN LÝ SINH VIÊN</a>
            </div>
            <div>
                <a href="/product/list">Danh sách sản phẩm</a>
                <a href="/product/create">Thêm sản phẩm</a>
                <a href="/category/list">Danh sách danh mục</a>
                <a href="/category/create">Thêm danh mục</a>
            </div>
        </div>
    </nav>

    <!-- Nội dung chính -->
    <div class="container">
        <?php echo $content; ?>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <p>&copy; 2025 Quản lý sản phẩm. All rights reserved.</p>
    </footer>
</body>
</html>