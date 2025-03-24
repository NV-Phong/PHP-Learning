<?php
ob_start();
?>

<div class="bg-white p-6 rounded-lg shadow-md">
   <h1 class="text-2xl font-bold text-gray-800 mb-4">Xác nhận đăng ký học phần</h1>
   <div class="mb-6">
      <h2 class="text-lg font-semibold text-gray-700 mb-3">Thông tin đăng ký</h2>
      <div class="space-y-3">
         <p><span class="font-bold w-32 inline-block">Mã sinh viên:</span>
            <?= htmlspecialchars($_SESSION['user']['MaSV']) ?></p>
         <p><span class="font-bold w-32 inline-block">Họ tên:</span> <?= htmlspecialchars($_SESSION['user']['HoTen']) ?>
         </p>
         <p><span class="font-bold w-32 inline-block">Ngày sinh:</span>
            <?= htmlspecialchars($_SESSION['user']['NgaySinh']) ?></p>
         <p><span class="font-bold w-32 inline-block">Ngành học:</span> <?= htmlspecialchars($nganhHoc['TenNganh']) ?>
         </p>
         <p><span class="font-bold w-32 inline-block">Ngày đăng ký:</span> <?= date('d/m/Y') ?></p>
      </div>
   </div>
   <div class="mb-6">
      <h2 class="text-lg font-semibold text-gray-700 mb-3">Danh sách học phần</h2>
      <?php if (empty($hocPhans)): ?>
         <p class="text-gray-500">Không có học phần nào được chọn.</p>
      <?php else: ?>
         <table class="w-full border-collapse mb-4">
            <thead>
               <tr class="bg-gray-200">
                  <th class="border p-3 text-left">Mã HP</th>
                  <th class="border p-3 text-left">Tên học phần</th>
                  <th class="border p-3 text-left">Số tín chỉ</th>
               </tr>
            </thead>
            <tbody>
               <?php foreach ($hocPhans as $hocPhan): ?>
                  <tr class="hover:bg-gray-50">
                     <td class="border p-3"><?= htmlspecialchars($hocPhan['MaHP']) ?></td>
                     <td class="border p-3"><?= htmlspecialchars($hocPhan['TenHP']) ?></td>
                     <td class="border p-3"><?= htmlspecialchars($hocPhan['SoTinChi']) ?></td>
                  </tr>
               <?php endforeach; ?>
            </tbody>
         </table>
      <?php endif; ?>
   </div>
   <form method="POST" action="/dangkyhocphan/save" class="space-y-4">
      <div class="flex space-x-3">
         <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Xác nhận</button>
         <a href="/dangkyhocphan/cart" class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400">Hủy</a>
      </div>
   </form>
</div>

<?php
$content = ob_get_clean();
$title = "Xác nhận đăng ký học phần";
require_once __DIR__ . '/../qlsv-layout.php';