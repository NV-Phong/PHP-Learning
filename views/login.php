<?php
ob_start();
?>

<div class="bg-white p-6 rounded-lg shadow-md max-w-md mx-auto mt-10">
   <h1 class="text-2xl font-bold text-gray-800 mb-4">Đăng nhập</h1>
   <?php if (isset($error)): ?>
      <p class="text-red-500 mb-4"><?php echo htmlspecialchars($error); ?></p>
   <?php endif; ?>
   <form method="POST" action="/login" class="space-y-4">
      <div>
         <label for="maSV" class="block text-sm font-medium text-gray-700">Mã sinh viên:</label>
         <input type="text" id="maSV" name="maSV" required
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm p-2">
      </div>
      <div>
         <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Đăng nhập</button>
      </div>
   </form>
</div>

<?php
$content = ob_get_clean();
$title = "Đăng nhập";
require_once __DIR__ . '/qlsv-layout.php';