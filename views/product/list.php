<?php
ob_start();
?>

<div class="bg-white p-6 rounded-lg shadow-md">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold text-gray-800">Danh sách sản phẩm</h1>
        <a href="/product/create" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Thêm sản phẩm
            mới</a>
    </div>
    <table class="w-full border-collapse">
        <thead>
            <tr class="bg-gray-200">
                <th class="border p-3 text-left">ID</th>
                <th class="border p-3 text-left">Danh mục</th>
                <th class="border p-3 text-left">Tên sản phẩm</th>
                <th class="border p-3 text-left">Giá</th>
                <th class="border p-3 text-left">Hình ảnh</th>
                <th class="border p-3 text-left">Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product): ?>
                <tr class="hover:bg-gray-50">
                    <td class="border p-3"><?= htmlspecialchars($product['IDProduct']) ?></td>
                    <td class="border p-3"><?= htmlspecialchars($product['CategoryName']) ?></td>
                    <td class="border p-3"><?= htmlspecialchars($product['ProductName']) ?></td>
                    <td class="border p-3"><?= number_format($product['Price'], 2) ?> VNĐ</td>
                    <td class="border p-3">
                        <?php if ($product['ImageURL']): ?>
                            <img src="<?= htmlspecialchars($product['ImageURL']) ?>" alt="Product Image"
                                class="w-12 h-12 object-cover rounded">
                        <?php else: ?>
                            Không có ảnh
                        <?php endif; ?>
                    </td>
                    <td class="border p-3">
                        <a href="/product/<?= $product['IDProduct'] ?>" class="text-blue-500 hover:underline">Xem</a> |
                        <a href="/product/edit/<?= $product['IDProduct'] ?>" class="text-green-500 hover:underline">Sửa</a>
                        |
                        <a href="/product/delete/<?= $product['IDProduct'] ?>"
                            onclick="return confirm('Bạn có chắc muốn xóa?')" class="text-red-500 hover:underline">Xóa</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php
$content = ob_get_clean();
$title = "Danh sách sản phẩm";
require_once __DIR__ . '/../layout.php';