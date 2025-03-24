<?php
ob_start();
?>

<div class="bg-white p-6 rounded-lg shadow-md">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold text-gray-800">Danh sách sinh viên</h1>
        <a href="/sinhvien/create" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Thêm sinh viên mới</a>
    </div>
    <table class="w-full border-collapse">
        <thead>
            <tr class="bg-gray-200">
                <th class="border p-3 text-left">Mã SV</th>
                <th class="border p-3 text-left">Họ tên</th>
                <th class="border p-3 text-left">Giới tính</th>
                <th class="border p-3 text-left">Ngày sinh</th>
                <th class="border p-3 text-left">Ngành học</th>
                <th class="border p-3 text-left">Hình ảnh</th>
                <th class="border p-3 text-left">Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($sinhViens as $sinhVien): ?>
                <tr class="hover:bg-gray-50">
                    <td class="border p-3"><?= htmlspecialchars($sinhVien['MaSV']) ?></td>
                    <td class="border p-3"><?= htmlspecialchars($sinhVien['HoTen']) ?></td>
                    <td class="border p-3"><?= htmlspecialchars($sinhVien['GioiTinh']) ?></td>
                    <td class="border p-3"><?= htmlspecialchars($sinhVien['NgaySinh']) ?></td>
                    <td class="border p-3"><?= htmlspecialchars($sinhVien['TenNganh']) ?></td>
                    <td class="border p-3">
                        <?php if ($sinhVien['Hinh']): ?>
                            <img src="<?= htmlspecialchars($sinhVien['Hinh']) ?>" alt="Hình ảnh" class="w-12 h-12 object-cover rounded">
                        <?php else: ?>
                            Không có ảnh
                        <?php endif; ?>
                    </td>
                    <td class="border p-3">
                        <a href="/sinhvien/<?= $sinhVien['MaSV'] ?>" class="text-blue-500 hover:underline">Xem</a> |
                        <a href="/sinhvien/edit/<?= $sinhVien['MaSV'] ?>" class="text-green-500 hover:underline">Sửa</a> |
                        <a href="/sinhvien/delete/<?= $sinhVien['MaSV'] ?>" class="text-red-500 hover:underline">Xóa</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php
$content = ob_get_clean();
$title = "Danh sách sinh viên";
require_once __DIR__ . '/../qlsv-layout.php';