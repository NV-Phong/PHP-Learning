<?php
ob_start();
?>

<div class="bg-white p-6 rounded-lg shadow-md">
   <h1 class="text-2xl font-bold text-gray-800 mb-4">Đăng ký học phần</h1>
   <table class="w-full border-collapse mb-6">
      <thead>
         <tr class="bg-gray-200">
            <th class="border p-3 text-left">Mã HP</th>
            <th class="border p-3 text-left">Tên học phần</th>
            <th class="border p-3 text-left">Số tín chỉ</th>
            <th class="border p-3 text-left">Số lượng dự kiến</th>
            <th class="border p-3 text-left">Hành động</th>
         </tr>
      </thead>
      <tbody>
         <?php foreach ($hocPhans as $hocPhan): ?>
            <tr class="hover:bg-gray-50">
               <td class="border p-3"><?= htmlspecialchars($hocPhan['MaHP']) ?></td>
               <td class="border p-3"><?= htmlspecialchars($hocPhan['TenHP']) ?></td>
               <td class="border p-3"><?= htmlspecialchars($hocPhan['SoTinChi']) ?></td>
               <td class="border p-3"><?= htmlspecialchars($hocPhan['SoLuongDuKien']) ?></td>
               <td class="border p-3">
                  <?php if (!in_array($hocPhan['MaHP'], $cart)): ?>
                     <a href="/dangkyhocphan/add/<?= $hocPhan['MaHP'] ?>"
                        class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">Đăng Ký</a>
                  <?php else: ?>
                     <span class="text-green-500">Đã thêm</span>
                  <?php endif; ?>
               </td>
            </tr>
         <?php endforeach; ?>
      </tbody>
   </table>
   <a href="/dangkyhocphan/cart" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Xem giỏ hàng</a>
</div>

<?php
$content = ob_get_clean();
$title = "Đăng ký học phần";
require_once __DIR__ . '/../qlsv-layout.php';