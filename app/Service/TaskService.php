<?php
namespace WorkSpace\Service;

use WorkSpace\Model\Task;

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
}