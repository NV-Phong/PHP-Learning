<?php
ob_start();
?>

<div class="bg-white p-6 rounded-lg shadow-md">
    <h1 class="text-2xl font-bold text-gray-800 mb-4">Xóa sinh viên</h1>
    <div class="mb-6">
        <h2 class="text-lg font-semibold text-gray-700 mb-3">Thông tin sinh viên</h2>
        <div class="space-y-3">
            <p><span class="font-bold w-32 inline-block">Mã SV:</span> <?= htmlspecialchars($sinhVien['MaSV']) ?></p>
            <p><span class="font-bold w-32 inline-block">Họ tên:</span> <?= htmlspecialchars($sinhVien['HoTen']) ?></p>
            <p><span class="font-bold w-32 inline-block">Giới tính:</span>
                <?= htmlspecialchars($sinhVien['GioiTinh']) ?></p>
            <p><span class="font-bold w-32 inline-block">Ngày sinh:</span>
                <?= htmlspecialchars($sinhVien['NgaySinh']) ?></p>
            <p><span class="font-bold w-32 inline-block">Ngành học:</span>
                <?= htmlspecialchars($sinhVien['TenNganh']) ?></p>
            <p><span class="font-bold w-32 inline-block">Hình ảnh:</span><br>
                <?php if ($sinhVien['Hinh']): ?>
                    <img src="<?= htmlspecialchars($sinhVien['Hinh']) ?>" alt="Hình ảnh"
                        class="w-48 h-48 object-cover rounded mt-2">
                <?php else: ?>
                    Không có ảnh
                <?php endif; ?>
            </p>
        </div>
    </div>
    <div class="mb-4">
        <p class="text-lg text-gray-700">Bạn có chắc chắn muốn xóa sinh viên
            <strong><?= htmlspecialchars($sinhVien['HoTen']) ?></strong> (Mã SV:
            <?= htmlspecialchars($sinhVien['MaSV']) ?>) không?</p>
        <p class="text-sm text-gray-500 mt-2">Hành động này sẽ đánh dấu sinh viên là đã xóa (xóa mềm) và không thể hoàn
            tác trực tiếp.</p>
    </div>
    <form method="POST" action="/sinhvien/delete/<?php echo $sinhVien['MaSV']; ?>" class="space-y-4">
        <div class="flex space-x-3">
            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Xóa</button>
            <a href="/sinhvien/list" class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400">Hủy</a>
        </div>
    </form>
</div>

<?php
$content = ob_get_clean();
$title = "Xóa sinh viên";
require_once __DIR__ . '/../qlsv-layout.php';