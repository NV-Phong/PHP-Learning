<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm sản phẩm</title>
    <style>
        .form-container { max-width: 600px; margin: 20px auto; padding: 20px; border: 1px solid #ddd; border-radius: 5px; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; }
        .form-group input, .form-group textarea, .form-group select { width: 100%; padding: 8px; box-sizing: border-box; }
    </style>
</head>
<body>
    <div class="form-container">
        <h1>Thêm sản phẩm mới</h1>
        <form method="POST" action="/product/create" enctype="multipart/form-data">
            <div class="form-group">
                <label for="idCategory">Danh mục:</label>
                <select id="idCategory" name="idCategory" required>
                    <option value="">Chọn danh mục</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= htmlspecialchars($category['IDCategory']) ?>">
                            <?= htmlspecialchars($category['CategoryName']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="name">Tên sản phẩm:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="description">Mô tả:</label>
                <textarea id="description" name="description" rows="4"></textarea>
            </div>
            <div class="form-group">
                <label for="price">Giá:</label>
                <input type="number" step="0.01" id="price" name="price" required>
            </div>
            <div class="form-group">
                <label for="image">Hình ảnh:</label>
                <input type="file" id="image" name="image" accept="image/*">
            </div>
            <button type="submit">Thêm</button>
            <a href="/products">Quay lại</a>
        </form>
    </div>
</body>
</html>