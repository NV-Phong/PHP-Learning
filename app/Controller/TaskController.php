<?php
namespace WorkSpace\Controller;

use WorkSpace\Service\TaskService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Exception;

class TaskController
{
    private $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    public function getAllTasks(Request $request): JsonResponse  
    {
        try {
            // Lấy ID của user đang đăng nhập
            $IDUser = $request->attributes->get('USER')['IDUser'];
            
            // Lấy IDProject từ request
            $IDProject = $request->input('IDProject');
            
            // Validate IDProject
            if (!$IDProject) {
                return new JsonResponse([
                    'success' => false,
                    'message' => 'Project ID is required'
                ], 400);
            }
    
            // Kiểm tra project có tồn tại không
            $projectExists = \WorkSpace\Model\Project::where('IDProject', $IDProject)->exists();
            if (!$projectExists) {
                return new JsonResponse([
                    'success' => false,
                    'message' => 'Project does not exist'
                ], 404);
            }
    
            $tasks = $this->taskService->getAllTasksByProjectAndUser($IDProject);
            
            return new JsonResponse([
                'success' => true,
                'data' => $tasks,
                'message' => 'Tasks retrieved successfully'
            ], 200);
        } catch (Exception $e) {
            return new JsonResponse([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}