<?php
ob_start();
?>

<div class="bg-white p-6 rounded-lg shadow-md">
    <h1 class="text-2xl font-bold text-gray-800 mb-4">Sửa danh mục</h1>
    <form method="POST" action="/category/edit/<?php echo $category['IDCategory']; ?>" class="space-y-4">
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Tên danh mục:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($category['CategoryName']); ?>" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm p-2">
        </div>
        <div>
            <label for="description" class="block text-sm font-medium text-gray-700">Mô tả:</label>
            <textarea id="description" name="description" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm p-2"><?php echo htmlspecialchars($category['CategoryDescription']); ?></textarea>
        </div>
        <div>
            <label for="isDeleted" class="flex items-center">
                <input type="checkbox" id="isDeleted" name="isDeleted" <?php echo $category['IsDeleted'] ? 'checked' : ''; ?> class="mr-2">
                <span class="text-sm font-medium text-gray-700">Đánh dấu đã xóa</span>
            </label>
        </div>
        <div class="flex space-x-3">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Cập nhật</button>
            <a href="/category/list" class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400">Quay lại</a>
        </div>
    </form>
</div>

<?php
$content = ob_get_clean();
$title = "Sửa danh mục";
require_once __DIR__ . '/../layout.php'; // Đường dẫn đã đúng