<?php
ob_start();
?>

<div class="bg-white p-6 rounded-lg shadow-md">
    <h1 class="text-2xl font-bold text-gray-800 mb-4">Thêm sản phẩm mới</h1>
    <form method="POST" action="/product/create" enctype="multipart/form-data" class="space-y-4">
        <div>
            <label for="idCategory" class="block text-sm font-medium text-gray-700">Danh mục:</label>
            <select id="idCategory" name="idCategory" required
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm p-2">
                <option value="">Chọn danh mục</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= htmlspecialchars($category['IDCategory']) ?>">
                        <?= htmlspecialchars($category['CategoryName']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Tên sản phẩm:</label>
            <input type="text" id="name" name="name" required
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm p-2">
        </div>
        <div>
            <label for="description" class="block text-sm font-medium text-gray-700">Mô tả:</label>
            <textarea id="description" name="description" rows="4"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm p-2"></textarea>
        </div>
        <div>
            <label for="price" class="block text-sm font-medium text-gray-700">Giá:</label>
            <input type="number" step="0.01" id="price" name="price" required
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm p-2">
        </div>
        <div>
            <label for="image" class="block text-sm font-medium text-gray-700">Hình ảnh:</label>
            <input type="file" id="image" name="image" accept="image/*" class="mt-1 block w-full">
        </div>
        <div class="flex space-x-3">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Thêm</button>
            <a href="/product/list" class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400">Quay lại</a>
        </div>
    </form>
</div>

<?php
$content = ob_get_clean();
$title = "Thêm sản phẩm";
require_once __DIR__ . '/../layout.php';