<?php
use Illuminate\Routing\Router;
use Phong\Controller\CategoryController;
use Phong\Controller\ProductController;

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
};