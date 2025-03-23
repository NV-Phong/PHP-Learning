<?php
ob_start();
?>

<div class="bg-white p-6 rounded-lg shadow-md">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold text-gray-800">Danh sách danh mục</h1>
        <a href="/category/create" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Thêm danh mục mới</a>
    </div>
    <table class="w-full border-collapse">
        <thead>
            <tr class="bg-gray-200">
                <th class="border p-3 text-left">ID</th>
                <th class="border p-3 text-left">Tên danh mục</th>
                <th class="border p-3 text-left">Mô tả</th>
                <th class="border p-3 text-left">Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($categories as $category): ?>
                <tr class="hover:bg-gray-50">
                    <td class="border p-3"><?= htmlspecialchars($category['IDCategory']) ?></td>
                    <td class="border p-3"><?= htmlspecialchars($category['CategoryName']) ?></td>
                    <td class="border p-3"><?= htmlspecialchars($category['CategoryDescription']) ?></td>
                    <td class="border p-3">
                        <a href="/category/<?= $category['IDCategory'] ?>" class="text-blue-500 hover:underline">Xem</a> |
                        <a href="/category/edit/<?= $category['IDCategory'] ?>" class="text-green-500 hover:underline">Sửa</a> |
                        <a href="/category/delete/<?= $category['IDCategory'] ?>" onclick="return confirm('Bạn có chắc muốn xóa?')" class="text-red-500 hover:underline">Xóa</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php
$content = ob_get_clean();
$title = "Danh sách danh mục";
require_once __DIR__ . '/../layout.php';