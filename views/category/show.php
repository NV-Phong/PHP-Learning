<?php
ob_start();
?>

<div class="bg-white p-6 rounded-lg shadow-md">
    <h1 class="text-2xl font-bold text-gray-800 mb-4">Chi tiết danh mục</h1>
    <div class="space-y-3">
        <p><span class="font-bold w-32 inline-block">ID:</span> <?= htmlspecialchars($category['IDCategory']) ?></p>
        <p><span class="font-bold w-32 inline-block">Tên danh mục:</span> <?= htmlspecialchars($category['CategoryName']) ?></p>
        <p><span class="font-bold w-32 inline-block">Mô tả:</span> <?= htmlspecialchars($category['CategoryDescription']) ?></p>
    </div>
    <a href="/category/list" class="mt-4 inline-block bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400">Quay lại</a>
</div>

<?php
$content = ob_get_clean();
$title = "Chi tiết danh mục";
require_once __DIR__ . '/../layout.php'; // Đường dẫn đã đúng