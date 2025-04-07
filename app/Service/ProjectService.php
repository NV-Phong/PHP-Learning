<?php
namespace WorkSpace\Service;
use Exception;
use WorkSpace\Model\Project;
use WorkSpace\Model\Team;
use WorkSpace\Model\ProjectAccess;

class ProjectService
{
    private $project;
    private $team;
    private $projectAccessModel;


    public function __construct(Project $project, Team $team ,ProjectAccess $projectAccessModel)
    {
        $this->project = $project;
        $this->team = $team;
        $this-> $projectAccessModel = $projectAccessModel;

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

    public function pathProjectAccess($projectId, $collaboratorId, $permission)
    {
        if (!in_array($permission, ['Owner', 'Edit', 'View'])) {
            throw new Exception('Giá trị quyền không hợp lệ');
        }

        $access = ProjectAccess::where('IDProject', $projectId)
            ->where('IDCollaborator', $collaboratorId)
            ->where('IsDeleted', false)
            ->first();

        if (!$access) {
            throw new Exception('Không tìm thấy quyền truy cập tương ứng');
        }

        $access->Permission = $permission;
        $access->save();

        return $access;
    }

}