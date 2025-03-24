<?php
ob_start();
?>

<div class="bg-white p-6 rounded-lg shadow-md">
   <h1 class="text-2xl font-bold text-gray-800 mb-4">Chi tiết sinh viên</h1>
   <div class="space-y-3">
      <p><span class="font-bold w-32 inline-block">Mã SV:</span> <?= htmlspecialchars($sinhVien['MaSV']) ?></p>
      <p><span class="font-bold w-32 inline-block">Họ tên:</span> <?= htmlspecialchars($sinhVien['HoTen']) ?></p>
      <p><span class="font-bold w-32 inline-block">Giới tính:</span> <?= htmlspecialchars($sinhVien['GioiTinh']) ?></p>
      <p><span class="font-bold w-32 inline-block">Ngày sinh:</span> <?= htmlspecialchars($sinhVien['NgaySinh']) ?></p>
      <p><span class="font-bold w-32 inline-block">Ngành học:</span> <?= htmlspecialchars($sinhVien['TenNganh']) ?></p>
      <p><span class="font-bold w-32 inline-block">Hình ảnh:</span><br>
         <?php if ($sinhVien['Hinh']): ?>
            <img src="<?= htmlspecialchars($sinhVien['Hinh']) ?>" alt="Hình ảnh"
               class="w-48 h-48 object-cover rounded mt-2">
         <?php else: ?>
            Không có ảnh
         <?php endif; ?>
      </p>
   </div>
   <a href="/sinhvien/list" class="mt-4 inline-block bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400">Quay
      lại</a>
</div>

<?php
$content = ob_get_clean();
$title = "Chi tiết sinh viên";
require_once __DIR__ . '/../qlsv-layout.php'; // Sử dụng layout mới