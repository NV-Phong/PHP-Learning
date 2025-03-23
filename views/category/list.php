<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách danh mục</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Danh sách danh mục</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên danh mục</th>
                <th>Mô tả</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($categories as $category): ?>
                <tr>
                    <td><?= htmlspecialchars($category['IDCategory']) ?></td>
                    <td><?= htmlspecialchars($category['CategoryName']) ?></td>
                    <td><?= htmlspecialchars($category['CategoryDescription']) ?></td>
                    <td>
                        <a href="/category/<?= $category['IDCategory'] ?>">Xem</a> |
                        <a href="/category/edit/<?= $category['IDCategory'] ?>">Sửa</a> |
                        <a href="/category/delete/<?= $category['IDCategory'] ?>" onclick="return confirm('Bạn có chắc muốn xóa?')">Xóa</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <a href="/category/create">Thêm danh mục mới</a>
</body>
</html>
