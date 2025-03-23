<?php
ob_start();
?>

<div class="bg-white p-6 rounded-lg shadow-md">
    <h1 class="text-2xl font-bold text-gray-800 mb-4">Sửa sản phẩm</h1>
    <form method="POST" action="/product/edit/<?php echo $product['IDProduct']; ?>" enctype="multipart/form-data" class="space-y-4">
        <div>
            <label for="idCategory" class="block text-sm font-medium text-gray-700">Danh mục:</label>
            <select id="idCategory" name="idCategory" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm p-2">
                <option value="">Chọn danh mục</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= htmlspecialchars($category['IDCategory']) ?>" 
                        <?= $category['IDCategory'] === $product['IDCategory'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($category['CategoryName']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Tên sản phẩm:</label>
            <input type="text" id="name" name="name" value="<?= htmlspecialchars($product['ProductName']) ?>" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm p-2">
        </div>
        <div>
            <label for="description" class="block text-sm font-medium text-gray-700">Mô tả:</label>
            <textarea id="description" name="description" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm p-2"><?= htmlspecialchars($product['ProductDescription']) ?></textarea>
        </div>
        <div>
            <label for="price" class="block text-sm font-medium text-gray-700">Giá:</label>
            <input type="number" step="0.01" id="price" name="price" value="<?= $product['Price'] ?>" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm p-2">
        </div>
        <div>
            <label for="image" class="block text-sm font-medium text-gray-700">Hình ảnh:</label>
            <?php if ($product['ImageURL']): ?>
                <img src="<?= htmlspecialchars($product['ImageURL']) ?>" alt="Current Image" class="w-24 h-24 object-cover rounded mb-2">
            <?php endif; ?>
            <input type="file" id="image" name="image" accept="image/*" class="mt-1 block w-full">
        </div>
        <div>
            <label for="isDeleted" class="flex items-center">
                <input type="checkbox" id="isDeleted" name="isDeleted" <?= $product['IsDeleted'] ? 'checked' : '' ?> class="mr-2">
                <span class="text-sm font-medium text-gray-700">Đánh dấu đã xóa</span>
            </label>
        </div>
        <div class="flex space-x-3">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Cập nhật</button>
            <a href="/product/list" class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400">Quay lại</a>
        </div>
    </form>
</div>

<?php
$content = ob_get_clean();
$title = "Sửa sản phẩm";
require_once __DIR__ . '/../layout.php';