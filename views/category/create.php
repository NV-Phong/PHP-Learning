<?php
ob_start();
?>

<div class="bg-white p-6 rounded-lg shadow-md">
    <h1 class="text-2xl font-bold text-gray-800 mb-4">Thêm danh mục mới</h1>
    <form method="POST" action="/category/create" class="space-y-4">
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Tên danh mục:</label>
            <input type="text" id="name" name="name" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm p-2">
        </div>
        <div>
            <label for="description" class="block text-sm font-medium text-gray-700">Mô tả:</label>
            <textarea id="description" name="description" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm p-2"></textarea>
        </div>
        <div class="flex space-x-3">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Thêm</button>
            <a href="/category/list" class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400">Quay lại</a>
        </div>
    </form>
</div>

<?php
$content = ob_get_clean();
$title = "Thêm danh mục";
require_once __DIR__ . '/../layout.php';