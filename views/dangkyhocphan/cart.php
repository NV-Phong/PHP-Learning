<?php
ob_start();
?>

<div class="bg-white p-6 rounded-lg shadow-md">
    <h1 class="text-2xl font-bold text-gray-800 mb-4">Giỏ hàng học phần</h1>
    <?php if (isset($_SESSION['message'])): ?>
        <p class="text-green-500 mb-4"><?php echo htmlspecialchars($_SESSION['message']); unset($_SESSION['message']); ?></p>
    <?php endif; ?>
    <?php if (empty($hocPhans)): ?>
        <p class="text-gray-500">Bạn chưa chọn học phần nào.</p>
    <?php else: ?>
        <table class="w-full border-collapse mb-6">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border p-3 text-left">Mã HP</th>
                    <th class="border p-3 text-left">Tên học phần</th>
                    <th class="border p-3 text-left">Số tín chỉ</th>
                    <th class="border p-3 text-left">Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($hocPhans as $hocPhan): ?>
                    <tr class="hover:bg-gray-50">
                        <td class="border p-3"><?= htmlspecialchars($hocPhan['MaHP']) ?></td>
                        <td class="border p-3"><?= htmlspecialchars($hocPhan['TenHP']) ?></td>
                        <td class="border p-3"><?= htmlspecialchars($hocPhan['SoTinChi']) ?></td>
                        <td class="border p-3">
                            <a href="/dangkyhocphan/cart/remove/<?= $hocPhan['MaHP'] ?>" class="text-red-500 hover:underline">Xóa</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="flex space-x-3">
            <a href="/dangkyhocphan/cart/clear" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Xóa toàn bộ</a>
            <a href="/dangkyhocphan/confirm" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Lưu đăng ký</a>
        </div>
    <?php endif; ?>
    <a href="/dangkyhocphan" class="mt-4 inline-block bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400">Quay lại</a>
</div>

<?php
$content = ob_get_clean();
$title = "Giỏ hàng học phần";
require_once __DIR__ . '/../qlsv-layout.php';