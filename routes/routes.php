<?php
use Illuminate\Routing\Router;
use Phong\Controller\CategoryController;

return function (Router $router) {
   $router->get('/categories', [CategoryController::class, 'index']);

   $router->get('/category/create', [CategoryController::class, 'create']);
   $router->post('/category/create', [CategoryController::class, 'create']);

   $router->get('/category/edit/{id}', [CategoryController::class, 'edit']);
   $router->post('/category/edit/{id}', [CategoryController::class, 'edit']);

   $router->get('/category/delete/{id}', [CategoryController::class, 'delete']);

   // Route có parameter nên để cuối cùng
   $router->get('/category/{id}', [CategoryController::class, 'show']);
};