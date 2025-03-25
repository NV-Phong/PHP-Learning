<?php
use Illuminate\Routing\Router;
use WorkSpace\Controller\AuthController;
use WorkSpace\Controller\HomeController;
use WorkSpace\Controller\WorkSpaceController;
use Middleware\Authenticate;

return function (Router $router) {
   $router->aliasMiddleware('auth', Authenticate::class);
   
   $router->group(['prefix' => '/'], function (Router $router) {
      $router->get('/', [HomeController::class, 'root']);
      $router->get('/user-inf', [HomeController::class, 'getUserInfoFromRequest'])->middleware('auth');
   });

   $router->group(['prefix' => 'auth'], function (Router $router) {
      $router->post('/register', [AuthController::class, 'Register']);
      $router->post('/login', [AuthController::class, 'Login']);
      $router->post('/refresh-token', [AuthController::class, 'RefreshToken']);
   });

   $router->group(['prefix'=> 'workspace'], function (Router $router){
      $router->get('/',[WorkSpaceController::class, 'index'])->middleware('auth');
      $router->post('/',[WorkSpaceController::class, 'create'])->middleware('auth');
   });
};