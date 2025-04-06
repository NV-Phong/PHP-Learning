<?php
namespace WorkSpace\Service;

use WorkSpace\Model\Task;
use Carbon\Carbon;

class TaskService
{
    private $taskModel;

    public function __construct(Task $taskModel)
    {
        $this->taskModel = $taskModel;
    }

    public function getAllTasksByProjectAndUser($IDProject)
    {
        try {
            return $this->taskModel->with(['project', 'status', 'tag', 'assignee', 'attachments'])
                ->where('IsDeleted', 0)
                ->where('IDProject', $IDProject)
                ->get();
        } catch (\Exception $e) {
            throw new \Exception("Error fetching tasks: " . $e->getMessage());
        }
    }
    public function createTask(array $data, $createdBy): Task
{
    try {
        // Kiểm tra các trường bắt buộc
        if (!isset($data['IDProject']) || !isset($data['TaskName'])) {
            throw new \Exception("Missing required fields: IDProject, TaskName");
        }

        // Kiểm tra xem IDProject có tồn tại không
        $projectExists = \WorkSpace\Model\Project::where('IDProject', $data['IDProject'])->exists();
        if (!$projectExists) {
            throw new \Exception("Project does not exist.");
        }
        $taskExists = \WorkSpace\Model\Task::where('IDProject', $data['IDProject'])
        ->where('TaskName', $data['TaskName'])
        ->where('IsDeleted', 0) // Chỉ kiểm tra các task chưa bị xóa
        ->exists();
         if ($taskExists) {
        throw new \Exception("Task name '{$data['TaskName']}' already exists in this project.");
     }
        // Kiểm tra Priority nếu có
        if (isset($data['Priority']) && !in_array($data['Priority'], ['Low', 'Medium', 'High'])) {
            throw new \Exception("Invalid Priority value. Must be Low, Medium, or High.");
        }

        // Tạo task mới
        $task = $this->taskModel->create([
            'IDProject' => $data['IDProject'],
            'TaskName' => $data['TaskName'],
            'IDStatus' => $data['IDStatus'] ?? null,
            'IDTag' => $data['IDTag'] ?? null,
            'IDAssignee' => $data['IDAssignee'] ?? null,
            'Priority' => $data['Priority'] ?? 'Low',
            'StartDay' => $data['StartDay'] ?? null,
            'EndDay' => $data['EndDay'] ?? null,
            'DueDay' => $data['DueDay'] ?? null,
            'CreatedAt' => Carbon::now(),
        ]);

        // Load relationships
        return $task->load(['project', 'status', 'tag', 'assignee', 'attachments']);

    } catch (\Exception $e) {
        throw new \Exception("Error creating task: " . $e->getMessage());
    }
}
    public function deleteTask($IDTask, $IDUser)
    {   
        $task = Task::where('IDTask', $IDTask)
                    ->where('IsDeleted', false)
                    ->first();
        if (!$task) {
            throw new \Exception('Task not found or already deleted');
        }
        $project = \WorkSpace\Model\Project::where('IDProject', $task->IDProject)
                    ->first();
        if (!$project) {
            throw new \Exception('Project not found');
        }
        $team = \WorkSpace\Model\Team::where('IDTeam', $project->IDTeam)
                    ->where('IDLeader', $IDUser)
                    ->first();
        if (!$team) {
            throw new \Exception('You do not have permission to delete this task');
        }
        $task->IsDeleted = true;
        $task->save();
        return ['message' => 'Task deleted successfully'];
    }
    public function assignTask($IDTask,$IDUser, $IDAssignee)
    {
        $task = Task::where('IDTask', $IDTask)
                    ->where('IsDeleted', false)
                    ->first();

        if (!$task) {
            throw new \Exception('Task not found or already deleted');
        }
        if ($IDAssignee === null) {
            $IDAssignee = $IDUser;
        }
        $task->IDAssignee = $IDAssignee;
        $task->save();

        return ['message' => 'Task assigned successfully'];
    }
}