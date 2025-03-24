<?php
use Illuminate\Routing\Router;
use Phong\Controller\CategoryController;
use Phong\Controller\ProductController;
use Phong\Controller\SinhVienController;
use Phong\Controller\DangKyHocPhanController;
use Phong\Controller\AuthController;

return function (Router $router) {
   // Nhóm routes cho Category
   $router->group(['prefix' => 'category'], function (Router $router) {
      $router->get('/list', [CategoryController::class, 'index']);

      $router->get('/create', [CategoryController::class, 'create']);
      $router->post('/create', [CategoryController::class, 'create']);

      $router->get('/edit/{id}', [CategoryController::class, 'edit']);
      $router->post('/edit/{id}', [CategoryController::class, 'edit']);

      $router->get('/delete/{id}', [CategoryController::class, 'delete']);

      $router->get('/{id}', [CategoryController::class, 'show']);
   });

   // Nhóm routes cho Product
   $router->group(['prefix' => 'product'], function (Router $router) {
      $router->get('/list', [ProductController::class, 'index']);

      $router->get('/create', [ProductController::class, 'create']);
      $router->post('/create', [ProductController::class, 'create']);

      $router->get('/edit/{id}', [ProductController::class, 'edit']);
      $router->post('/edit/{id}', [ProductController::class, 'edit']);

      $router->get('/delete/{id}', [ProductController::class, 'delete']);

      $router->get('/{id}', [ProductController::class, 'show']);
   });

   // Nhóm routes cho SinhVien
   $router->group(['prefix' => 'sinhvien'], function (Router $router) {
      $router->get('/list', [SinhVienController::class, 'index']);

      $router->get('/create', [SinhVienController::class, 'create']);
      $router->post('/create', [SinhVienController::class, 'create']);

      $router->get('/edit/{id}', [SinhVienController::class, 'edit']);
      $router->post('/edit/{id}', [SinhVienController::class, 'edit']);

      $router->get('/delete/{id}', [SinhVienController::class, 'delete']);
      $router->post('/delete/{id}', [SinhVienController::class, 'delete']);

      $router->get('/{id}', [SinhVienController::class, 'show']);
   });

   // Nhóm routes cho Đăng ký học phần
   $router->group(['prefix' => 'dangkyhocphan'], function (Router $router) {
      $router->get('/', [DangKyHocPhanController::class, 'index']);
      $router->get('/add/{maHP}', [DangKyHocPhanController::class, 'addToCart']);
      $router->get('/cart', [DangKyHocPhanController::class, 'cart']);
      $router->get('/cart/remove/{maHP}', [DangKyHocPhanController::class, 'removeFromCart']);
      $router->get('/cart/clear', [DangKyHocPhanController::class, 'clearCart']);
      $router->get('/confirm', [DangKyHocPhanController::class, 'confirm']); // Thêm route cho xác nhận
      $router->post('/save', [DangKyHocPhanController::class, 'save']); // Thay đổi save thành POST
   });

   $router->get('/login', [AuthController::class, 'login']);
   $router->post('/login', [AuthController::class, 'login']);
   $router->get('/logout', [AuthController::class, 'logout']);
};