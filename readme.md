### AUTHOR

-  Name : `Nguyễn Văn Phong`
-  MSSV : `2180607874`
-  Email : `ui.engineer.workspace@gmail.com`

### INSTALL

Trước tiên, cần cài đặt các package cần thiết bằng Composer:

```sh
composer install
```

### RUN PROJECT

Chạy ứng dụng với lệnh:

```sh
composer start
```

Lệnh này sẽ:

-  Bỏ giới hạn thời gian xử lý của Composer.
-  Khởi chạy PHP built-in server tại `http://localhost:3000` với thư mục `app` làm gốc.

Bạn cũng có thể chạy trực tiếp bằng:

```sh
php -S localhost:3000 -t public
```

Hoặc nếu dùng XAMPP :

-  Đặt dự án trong thư mục `htdocs`
-  Trỏ đến thư mục public để chạy dự án
-  Ví dụ : `http://localhost/WS-Server/public/`
