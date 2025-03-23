<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Danh sách sản phẩm</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        table, th, td { border: 1px solid black; }
        th, td { padding: 10px; text-align: left; }
        th { background-color: #f2f2f2; }
        img { max-width: 50px; }
    </style>
</head>
<body>
    <h1>Danh sách sản phẩm</h1>
    <a href="/product/create">Thêm sản phẩm mới</a><br><br>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Danh mục</th>
                <th>Tên sản phẩm</th>
                <th>Giá</th>
                <th>Hình ảnh</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product): ?>
                <tr>
                    <td><?= htmlspecialchars($product['IDProduct']) ?></td>
                    <td><?= htmlspecialchars($product['CategoryName']) ?></td>
                    <td><?= htmlspecialchars($product['ProductName']) ?></td>
                    <td><?= number_format($product['Price'], 2) ?></td>
                    <td><img src="<?= htmlspecialchars($product['ImageURL']) ?>" alt="Product Image"></td>
                    <td>
                        <a href="/product/<?= $product['IDProduct'] ?>">Xem</a> |
                        <a href="/product/edit/<?= $product['IDProduct'] ?>">Sửa</a> |
                        <a href="/product/delete/<?= $product['IDProduct'] ?>" onclick="return confirm('Bạn có chắc muốn xóa?')">Xóa</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>