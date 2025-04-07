<?php
namespace WorkSpace\Service;
use Exception;
use WorkSpace\Model\Project;
use WorkSpace\Model\Team;

class ProjectService
{
    private $project;
    private $team;

    public function __construct(Project $project, Team $team)
    {
        $this->project = $project;
        $this->team = $team;
    }

    //tạo mới 1 project
    public function createNewProject($data)
    {
        $requiredFields = [
            "projectName" => "Project name is not blank"
        ];

        foreach ($requiredFields as $field => $message) {
            if (empty($data[$field])) {
                throw new Exception($message);
            }
        }

        $existTeam = Team::where('IDTeam', $data['IDTeam'])
            ->where('IsDeleted', false)
            ->first();

        if (!$existTeam) {
            throw new Exception('Team does not exist');
        }

        $existProject = Project::where('ProjectName', $data['projectName'])
            ->where('IDTeam', $data['IDTeam'])
            ->where('IsDeleted', false)
            ->first();

        if ($existProject) {
            throw new Exception('Project already exists');
        } else {
            return $this->project->create([
                "IDTeam" => $data["IDTeam"],
                "ProjectName" => $data["projectName"],
                "ProjectDescription" => $data["projectDescription"],
            ]);
        }
    }

    // Lấy danh sách dự án theo IDTeam
    public function getProjectsByTeamId($teamId)
    {
        if (empty($teamId)) {
            throw new Exception('Team ID is required');
        }

        $existTeam = Team::where('IDTeam', $teamId)
            ->where('IsDeleted', false)
            ->first();

        if (!$existTeam) {
            throw new Exception('Team does not exist');
        }

        return Project::where('IDTeam', $teamId)
            ->where('IsDeleted', false)
            ->get();
    }
    public function deleteProject($projectId)
    {
        if (empty($projectId)) {
            throw new Exception('Project ID is required');
        }

        $project = Project::where('IDProject', $projectId)
            ->where('IsDeleted', false)
            ->first();

        if (!$project) {
            throw new Exception('Project does not exist or has already been deleted');
        }

        $project->IsDeleted = true; 
        
        if ($project->save()) {
            return true; 
        }
        
        throw new Exception('Failed to delete project');
    }

}