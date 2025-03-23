<?php
ob_start();
?>

<div class="bg-white p-6 rounded-lg shadow-md">
    <h1 class="text-2xl font-bold text-gray-800 mb-4">Chi tiết sản phẩm</h1>
    <div class="space-y-3">
        <p><span class="font-bold w-32 inline-block">ID:</span> <?= htmlspecialchars($product['IDProduct']) ?></p>
        <p><span class="font-bold w-32 inline-block">Danh mục:</span> <?= htmlspecialchars($product['CategoryName']) ?>
        </p>
        <p><span class="font-bold w-32 inline-block">Tên sản phẩm:</span>
            <?= htmlspecialchars($product['ProductName']) ?></p>
        <p><span class="font-bold w-32 inline-block">Mô tả:</span>
            <?= htmlspecialchars($product['ProductDescription']) ?></p>
        <p><span class="font-bold w-32 inline-block">Giá:</span> <?= number_format($product['Price'], 2) ?> VNĐ</p>
        <p><span class="font-bold w-32 inline-block">Hình ảnh:</span><br>
            <?php if ($product['ImageURL']): ?>
                <img src="<?= htmlspecialchars($product['ImageURL']) ?>" alt="Product Image"
                    class="w-48 h-48 object-cover rounded mt-2">
            <?php else: ?>
                Không có ảnh
            <?php endif; ?>
        </p>
    </div>
    <a href="/product/list" class="mt-4 inline-block bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400">Quay
        lại</a>
</div>

<?php
$content = ob_get_clean();
$title = "Chi tiết sản phẩm";
require_once __DIR__ . '/../layout.php';