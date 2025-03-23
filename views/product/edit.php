<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sửa sản phẩm</title>
    <style>
        .form-container { max-width: 600px; margin: 20px auto; padding: 20px; border: 1px solid #ddd; border-radius: 5px; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; }
        .form-group input, .form-group textarea, .form-group select { width: 100%; padding: 8px; box-sizing: border-box; }
        img { max-width: 100px; }
    </style>
</head>
<body>
    <div class="form-container">
        <h1>Sửa sản phẩm</h1>
        <form method="POST" action="/product/edit/<?php echo $product['IDProduct']; ?>" enctype="multipart/form-data">
            <div class="form-group">
                <label for="idCategory">Danh mục:</label>
                <select id="idCategory" name="idCategory" required>
                    <option value="">Chọn danh mục</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= htmlspecialchars($category['IDCategory']) ?>" 
                            <?= $category['IDCategory'] === $product['IDCategory'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($category['CategoryName']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="name">Tên sản phẩm:</label>
                <input type="text" id="name" name="name" value="<?= htmlspecialchars($product['ProductName']) ?>" required>
            </div>
            <div class="form-group">
                <label for="description">Mô tả:</label>
                <textarea id="description" name="description" rows="4"><?= htmlspecialchars($product['ProductDescription']) ?></textarea>
            </div>
            <div class="form-group">
                <label for="price">Giá:</label>
                <input type="number" step="0.01" id="price" name="price" value="<?= $product['Price'] ?>" required>
            </div>
            <div class="form-group">
                <label for="image">Hình ảnh:</label>
                <?php if ($product['ImageURL']): ?>
                    <img src="<?= htmlspecialchars($product['ImageURL']) ?>" alt="Current Image"><br>
                <?php endif; ?>
                <input type="file" id="image" name="image" accept="image/*">
            </div>
            <div class="form-group">
                <label for="isDeleted">
                    <input type="checkbox" id="isDeleted" name="isDeleted" <?= $product['IsDeleted'] ? 'checked' : '' ?>>
                    Đánh dấu đã xóa
                </label>
            </div>
            <button type="submit">Cập nhật</button>
            <a href="/products">Quay lại</a>
        </form>
    </div>
</body>
</html>