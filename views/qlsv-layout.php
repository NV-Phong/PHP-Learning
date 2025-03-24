<!DOCTYPE html>
<html lang="vi">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title><?php echo isset($title) ? htmlspecialchars($title) : 'Quản lý sinh viên'; ?></title>
   <!-- Sử dụng Tailwind CSS từ CDN để làm đẹp giao diện -->
   <script src="https://cdn.tailwindcss.com"></script>
   <style>
      /* Tùy chỉnh giao diện riêng cho SinhVien */
      .container {
         max-width: 1200px;
         margin: 0 auto;
         padding: 20px;
      }

      .navbar {
         background-color: #2c5282;
         color: white;
         padding: 1rem;
      }

      /* Màu xanh đậm cho navbar */
      .navbar a {
         color: white;
         margin-right: 1rem;
         text-decoration: none;
      }

      .navbar a:hover {
         text-decoration: underline;
      }

      .footer {
         background-color: #e2e8f0;
         padding: 1rem;
         text-align: center;
         margin-top: 2rem;
      }

      body {
         background-color: #edf2f7;
      }

      /* Màu nền nhạt hơn */
   </style>
</head>

<body>
   <!-- Navigation -->
   <nav class="navbar">
      <div class="container flex justify-between items-center">
         <div>
            <a href="/sinhvien/list" class="text-lg font-bold">QUẢN LÝ SINH VIÊN</a>
         </div>
         <div>
            <a href="/sinhvien/list">Danh sách sinh viên</a>
            <a href="/sinhvien/create">Thêm sinh viên</a>
            <a href="/nganhhoc/list">Danh sách ngành học</a>
            <a href="/nganhhoc/create">Thêm ngành học</a>
            <!-- Liên kết quay lại các phần khác nếu cần -->
            <a href="/product/list">Quản lý sản phẩm</a>
         </div>
      </div>
   </nav>

   <!-- Nội dung chính -->
   <div class="container">
      <?php echo $content; ?>
   </div>

   <!-- Footer -->
   <footer class="footer">
      <p>© 2025 Quản lý sinh viên. All rights reserved.</p>
   </footer>
</body>

</html>