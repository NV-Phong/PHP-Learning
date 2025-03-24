<?php
ob_start();
?>

<div class="bg-white p-6 rounded-lg shadow-md">
   <h1 class="text-2xl font-bold text-gray-800 mb-4">Sửa sinh viên</h1>
   <form method="POST" action="/sinhvien/edit/<?php echo $sinhVien['MaSV']; ?>" enctype="multipart/form-data"
      class="space-y-4">
      <div>
         <label for="hoTen" class="block text-sm font-medium text-gray-700">Họ tên:</label>
         <input type="text" id="hoTen" name="hoTen" value="<?= htmlspecialchars($sinhVien['HoTen']) ?>" required
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm p-2">
      </div>
      <div>
         <label for="gioiTinh" class="block text-sm font-medium text-gray-700">Giới tính:</label>
         <select id="gioiTinh" name="gioiTinh" required
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm p-2">
            <option value="">Chọn giới tính</option>
            <option value="Nam" <?= $sinhVien['GioiTinh'] === 'Nam' ? 'selected' : '' ?>>Nam</option>
            <option value="Nữ" <?= $sinhVien['GioiTinh'] === 'Nữ' ? 'selected' : '' ?>>Nữ</option>
         </select>
      </div>
      <div>
         <label for="ngaySinh" class="block text-sm font-medium text-gray-700">Ngày sinh:</label>
         <input type="date" id="ngaySinh" name="ngaySinh" value="<?= htmlspecialchars($sinhVien['NgaySinh']) ?>"
            required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm p-2">
      </div>
      <div>
         <label for="maNganh" class="block text-sm font-medium text-gray-700">Ngành học:</label>
         <select id="maNganh" name="maNganh" required
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm p-2">
            <option value="">Chọn ngành học</option>
            <?php foreach ($nganhHoc as $nganh): ?>
               <option value="<?= htmlspecialchars($nganh['MaNganh']) ?>" <?= $nganh['MaNganh'] === $sinhVien['MaNganh'] ? 'selected' : '' ?>>
                  <?= htmlspecialchars($nganh['TenNganh']) ?>
               </option>
            <?php endforeach; ?>
         </select>
      </div>
      <div>
         <label for="hinh" class="block text-sm font-medium text-gray-700">Hình ảnh:</label>
         <?php if ($sinhVien['Hinh']): ?>
            <img src="<?= htmlspecialchars($sinhVien['Hinh']) ?>" alt="Hình ảnh hiện tại"
               class="w-24 h-24 object-cover rounded mb-2">
         <?php endif; ?>
         <input type="file" id="hinh" name="hinh" accept="image/*" class="mt-1 block w-full">
      </div>
      <div>
         <label for="isDeleted" class="flex items-center">
            <input type="checkbox" id="isDeleted" name="isDeleted" <?= $sinhVien['IsDeleted'] ? 'checked' : '' ?>
               class="mr-2">
            <span class="text-sm font-medium text-gray-700">Đánh dấu đã xóa</span>
         </label>
      </div>
      <div class="flex space-x-3">
         <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Cập nhật</button>
         <a href="/sinhvien/list" class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400">Quay lại</a>
      </div>
   </form>
</div>

<?php
$content = ob_get_clean();
$title = "Sửa sinh viên";
require_once __DIR__ . '/../qlsv-layout.php'; 