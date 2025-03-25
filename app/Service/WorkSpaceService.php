<?php
namespace WorkSpace\Service;
use Exception;
use WorkSpace\Model\WorkSpace;
use WorkSpace\Service\UserService;

class WorkSpaceService
{
   private $workSpace;
   private $userService;
   public function __construct(WorkSpace $workSpace, UserService $userService)
   {
      $this->workSpace = $workSpace;
      $this->userService = $userService;
   }

   public function getAllWorkSpaces($IDUser)
   {
      return WorkSpace::select("IDWorkspace", "WorkSpaceName", "WorkSpaceDescription")
      ->where([
         ['IDUser', $IDUser],
         ['IsDeleted', false]
      ])->get();
   }
   public function createWorkSpace($data, $IDUser)
   {
      $workSpace = $this->findWorkSpace('WorkSpaceName', $data['WorkSpaceName'], $IDUser);
      if ($workSpace) {
         throw new Exception('Tên WorkSpace đã tồn tại');
      }
      else {
         return WorkSpace::create([
            "IDUser" => $IDUser,
            "WorkSpaceName" => $data["WorkSpaceName"],
            "WorkSpaceDescription" => $data["WorkSpaceDescription"],
         ]);
      }
   }

   public function findWorkSpace($field, $value, $IDUser)
   {
      $workSpace = WorkSpace::where($field, $value)
         ->where('IDUser', $IDUser)
         ->where('IsDeleted', false)
         ->first();

      if (!$workSpace) {
         return null;
         //throw new Exception('Không tìm thấy WorkSpace');
      }

      return $workSpace;
   }
}