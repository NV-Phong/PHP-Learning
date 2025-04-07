<?php

namespace WorkSpace\Controller;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Exception;
use WorkSpace\Service\ProjectService;


class ProjectController
{
    private ProjectService $projectService;

    public function __construct(ProjectService $projectService )
    {
        $this->projectService = $projectService;
    }

    public function createNewProject(Request $request): JsonResponse
    {
        try {
            $NewProject = $this->projectService->createNewProject($request->json()->all());
            return new JsonResponse([
                'message' => 'Created New Project Successfully',
                'data' => $NewProject
            ], 201);
        } catch (Exception $exception) {
            return new JsonResponse([
                'message' => $exception->getMessage(),
            ], 400);
        }
    }

    public function getProjectsByTeamId(Request $request): JsonResponse
    {
        try {
            $teamId = $request->route('teamId');
            $projects = $this->projectService->getProjectsByTeamId($teamId);
            return new JsonResponse([
                'message' => 'Get projects successfully',
                'data' => $projects
            ], 200);
        } catch (Exception $exception) {
            return new JsonResponse([
                'message' => $exception->getMessage(),
            ], 400);
        }
    }

    public function patchProjectPermission(Request $request): JsonResponse
    {
        try {
            $projectId = $request->input('IDProject');
            $collaboratorId = $request->input('IDCollaborator');
            $permission = $request->input('Permission');

            $result = $this->projectService
                ->pathProjectAccess($projectId, $collaboratorId, $permission);

            return new JsonResponse([
                'message' => 'Update permission successfully',
                'data' => $result
            ], 200);
        } catch (Exception $exception) {
            return new JsonResponse([
                'message' => $exception->getMessage()
            ], 400);
        }
    }
    
}