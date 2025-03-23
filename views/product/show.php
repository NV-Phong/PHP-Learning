<!DOCTYPE html>
<html>
<head>
    <title>Chi tiết sản phẩm</title>
    <meta charset="UTF-8">
    <style>
        .product-details { max-width: 600px; margin: 20px auto; padding: 20px; border: 1px solid #ddd; border-radius: 5px; }
        .product-details h1 { color: #333; }
        .product-details p { margin: 10px 0; }
        .label { font-weight: bold; display: inline-block; width: 120px; }
        img { max-width: 200px; }
    </style>
</head>
<body>
    <div class="product-details">
        <h1>Chi tiết sản phẩm</h1>
        <p><span class="label">ID:</span><?= htmlspecialchars($product['IDProduct']) ?></p>
        <p><span class="label">Danh mục:</span><?= htmlspecialchars($product['CategoryName']) ?></p>
        <p><span class="label">Tên sản phẩm:</span><?= htmlspecialchars($product['ProductName']) ?></p>
        <p><span class="label">Mô tả:</span><?= htmlspecialchars($product['ProductDescription']) ?></p>
        <p><span class="label">Giá:</span><?= number_format($product['Price'], 2) ?></p>
        <p><span class="label">Hình ảnh:</span><br><img src="<?= htmlspecialchars($product['ImageURL']) ?>" alt="Product Image"></p>
    </div>
</body>
</html>