<?php
ob_start();
?>

<div class="bg-white p-6 rounded-lg shadow-md">
   <h1 class="text-2xl font-bold text-gray-800 mb-4">Thêm sinh viên mới</h1>
   <form method="POST" action="/sinhvien/create" enctype="multipart/form-data" class="space-y-4">
      <div>
         <label for="maSV" class="block text-sm font-medium text-gray-700">Mã sinh viên:</label>
         <input type="text" id="maSV" name="maSV" required
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm p-2">
      </div>
      <div>
         <label for="hoTen" class="block text-sm font-medium text-gray-700">Họ tên:</label>
         <input type="text" id="hoTen" name="hoTen" required
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm p-2">
      </div>
      <div>
         <label for="gioiTinh" class="block text-sm font-medium text-gray-700">Giới tính:</label>
         <select id="gioiTinh" name="gioiTinh" required
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm p-2">
            <option value="">Chọn giới tính</option>
            <option value="Nam">Nam</option>
            <option value="Nữ">Nữ</option>
         </select>
      </div>
      <div>
         <label for="ngaySinh" class="block text-sm font-medium text-gray-700">Ngày sinh:</label>
         <input type="date" id="ngaySinh" name="ngaySinh" required
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm p-2">
      </div>
      <div>
         <label for="maNganh" class="block text-sm font-medium text-gray-700">Ngành học:</label>
         <select id="maNganh" name="maNganh" required
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm p-2">
            <option value="">Chọn ngành học</option>
            <?php foreach ($nganhHoc as $nganh): ?>
               <option value="<?= htmlspecialchars($nganh['MaNganh']) ?>">
                  <?= htmlspecialchars($nganh['TenNganh']) ?>
               </option>
            <?php endforeach; ?>
         </select>
      </div>
      <div>
         <label for="hinh" class="block text-sm font-medium text-gray-700">Hình ảnh:</label>
         <input type="file" id="hinh" name="hinh" accept="image/*" class="mt-1 block w-full">
      </div>
      <div class="flex space-x-3">
         <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Thêm</button>
         <a href="/sinhvien/list" class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400">Quay lại</a>
      </div>
   </form>
</div>

<?php
$content = ob_get_clean();
$title = "Thêm sinh viên";
require_once __DIR__ . '/../qlsv-layout.php';