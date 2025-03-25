<?php
namespace WorkSpace\Controller;
use WorkSpace\Service\WorkSpaceService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Exception;

class WorkSpaceController
{
   private WorkSpaceService $WSService;

   public function __construct(WorkSpaceService $WSService)
   {
      $this->WSService = $WSService;
   }

   public function index(Request $request): JsonResponse
   {
      try {
         $IDUser = $request->attributes->get('USER')['IDUser'];
         print_r($IDUser);
         $workspaces = $this->WSService->getAllWorkSpaces($IDUser);
         return new JsonResponse([
            'message' => 'Danh sách WorkSpace',
            'data' => $workspaces
         ], 200);
      } catch (Exception $e) {
         return new JsonResponse([
            'message' => $e->getMessage(),
         ], 400);
      }
   }

   public function create(Request $request): JsonResponse
   {
      try {
         $IDUser = $request->attributes->get('USER')['IDUser'];
         $workSpace = $this->WSService->createWorkSpace($request->json()->all(), $IDUser);
         return new JsonResponse([
            'message' => 'Tạo WorkSpace thành công',
            'data' => $workSpace
         ], 201);
      } catch (Exception $e) {
         return new JsonResponse([
            'message' => $e->getMessage(),
         ], 400);
      }
   }
}