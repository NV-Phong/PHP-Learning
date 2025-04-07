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
    
            $tasks = $this->taskService->getAllTasksByProjectAndUser($IDProject)->makeHidden('IDProject');
            
            return new JsonResponse([
                'success' => true,
                'data' => $tasks,
             //   'IDProject' => $tasks[0]->IDProject ?? null,
                'message' => 'Tasks retrieved successfully'
            ], 200);
        } catch (Exception $e) {
            return new JsonResponse([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
    public function createTask(Request $request): JsonResponse
{
    try {
        // Lấy ID của user đang đăng nhập
        $IDUser = $request->attributes->get('USER')['IDUser'];

        // Lấy dữ liệu từ request
        $taskData = $request->json()->all();
        // Gọi service để tạo task
        $task = $this->taskService->createTask($taskData, $IDUser);
        $taskData = $task->toArray();
        unset($taskData['IDProject']);
        return new JsonResponse([
            'message' => 'Created Task Successfully',
            'data' => $taskData
        ], 201);
    } catch (Exception $e) {
        return new JsonResponse([
            'message' => $e->getMessage(),
        ], 400);
    }
}
    public function deleteTask(Request $request, $IDTask): JsonResponse
    {
        try {
            $IDUser = $request->attributes->get('USER')['IDUser'];
            $result = $this->taskService->deleteTask($IDTask, $IDUser);
            return new JsonResponse([
                'message' => $result['message']
            ], 200);
        } catch (Exception $e) {
            return new JsonResponse([
                'message' => $e->getMessage(),
            ], 400);
        }
    }
    public function assignTask(Request $request, $IDTask): JsonResponse
    {
        try {
            $IDUser = $request->attributes->get('USER')['IDUser'];
    
            $assigneeData = $request->json()->all();
            $IDAssignee = $assigneeData['IDAssignee'] ?? null;
    
            $result = $this->taskService->assignTask($IDTask, $IDUser, $IDAssignee);
    
            return new JsonResponse([
                'message' => $result['message']
            ], 200);
        } catch (\Exception $e) {
            return new JsonResponse([
                'message' => $e->getMessage(),
            ], 400);
        }
    }
    public function unassignTask(Request $request, $IDTask): JsonResponse
    {
        try {
            $IDUser = $request->attributes->get('USER')['IDUser'];
            $result = $this->taskService->unassignTask($IDTask, $IDUser);

            return new JsonResponse([
                'message' => $result['message']
            ], 200);
        } catch (\Exception $e) {
            return new JsonResponse([
                'message' => $e->getMessage(),
            ], 400);
        }
    }
}