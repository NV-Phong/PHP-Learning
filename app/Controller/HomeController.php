<?php
namespace WorkSpace\Controller;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class HomeController
{
   public function root()
   {
      return '🚀 WS-Server is running 🚀';
   }

   public function getUserInfoFromRequest(Request $request): JsonResponse
   {
      $user = $request->attributes->get('USER');
      $IDUser = $user['IDUser'];
      return new JsonResponse([
         'message' => 'User Inf',
         'user' => $user
      ], 200);
   }
}