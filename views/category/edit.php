<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sửa danh mục</title>
    <style>
        .form-container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input, .form-group textarea {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h1>Sửa danh mục</h1>
        <form method="POST" action="/category/edit/<?php echo $category['IDCategory']; ?>">
            <div class="form-group">
                <label for="name">Tên danh mục:</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($category['CategoryName']); ?>" required>
            </div>
            <div class="form-group">
                <label for="description">Mô tả:</label>
                <textarea id="description" name="description" rows="4"><?php echo htmlspecialchars($category['CategoryDescription']); ?></textarea>
            </div>
            <div class="form-group">
                <label for="isDeleted">
                    <input type="checkbox" id="isDeleted" name="isDeleted" <?php echo $category['IsDeleted'] ? 'checked' : ''; ?>>
                    Đánh dấu đã xóa
                </label>
            </div>
            <button type="submit">Cập nhật</button>
            <a href="/categories">Quay lại</a>
        </form>
    </div>
</body>
</html>