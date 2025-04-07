<?php
namespace WorkSpace\Service;
use Exception;
use WorkSpace\Model\WorkSpace;
use WorkSpace\Model\WorkSpaceAccess;

class WorkSpaceService
{
   private $workSpace;

   private $workSpaceAccess;
   public function __construct(WorkSpace $workSpace, WorkSpaceAccess $workSpaceAccess)
   {
      $this->workSpace = $workSpace;
      $this->workSpaceAccess = $workSpaceAccess;
   }

   public function getAllWorkSpaces($IDUser)
   {
      return WorkSpace::select("IDWorkspace", "WorkSpaceName", "WorkSpaceDescription")
         ->where([
            ['IDUser', $IDUser],
            ['IsDeleted', false]
         ])->get();
   }
   public function getWorkSpaceByIDWS($IDWorkSpace, $IDUser)
   {
      $workSpace = WorkSpace::select('IDWorkSpace', 'WorkSpaceName', 'WorkSpaceDescription')
         ->where([
               ['IDWorkSpace', $IDWorkSpace],
               ['IDUser', $IDUser],
               ['IsDeleted', false]
         ])
         ->first();

      if (!$workSpace) {
         throw new Exception('WorkSpace not found');
      }

      return $workSpace;
   }

   public function createWorkSpace($data, $IDUser)
   {
      $requiredFields = [
         'workspaceName' => 'WorkSpace Name is required',
      ];

      foreach ($requiredFields as $field => $message) {
         if (empty($data[$field])) {
            throw new Exception($message);
         }
      }
      $workSpace = $this->findWorkSpace('WorkSpaceName', $data['workspaceName'], $IDUser);
      if ($workSpace) {
         throw new Exception('WorkSpace already exists');
      } else {
         return WorkSpace::create([
            "IDUser" => $IDUser,
            "WorkSpaceName" => $data["workspaceName"],
            "WorkSpaceDescription" => $data["workspaceDescription"],
         ]);
      }
   }

   public function findWorkSpace($field, $value, $IDUser)
   {
      return WorkSpace::where($field, $value)
         ->where('IDUser', $IDUser)
         ->where('IsDeleted', false)
         ->first();
   }
   public function deleteWorkSpace($IDWorkspace, $IDUser)
   {
    // Tìm workspace dựa trên IDWorkspace và IDUser
    $workSpace = WorkSpace::where('IDWorkspace', $IDWorkspace)
        ->where('IDUser', $IDUser)
        ->where('IsDeleted', false)
        ->first();

    // Nếu không tìm thấy workspace, ném ra ngoại lệ
    if (!$workSpace) {
        throw new Exception('WorkSpace not found or already deleted');
    }

    // Đánh dấu workspace là đã xóa
    $workSpace->IsDeleted = true;
    $workSpace->save();

    return ['message' => 'WorkSpace deleted successfully'];
   }

   public function pathWorkSpaceAccess($IDWorkSpace, $collaboratorId, $permission)
    {
        if (!in_array($permission, ['Owner', 'Edit', 'View'])) {
            throw new Exception('Giá trị quyền không hợp lệ');
        }

        $access = WorkSpaceAccess::where('IDWorkSpace', $IDWorkSpace)
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
