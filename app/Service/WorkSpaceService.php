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

   public function getAllWorkSpaces()
   {
      return WorkSpace::where('IsDeleted', false)->get();
   }
   public function createWorkSpace($data)
   {
      $user = $this->userService->findUser('IDUser', $data['IDUser']);
      if (!$user) {
         throw new Exception('Không tìm thấy User');
      }
      else {
         $workSpace = $this->findWorkSpace('WorkSpaceName', $data['WorkSpaceName']);
         if ($workSpace) {
            throw new Exception('Tên WorkSpace đã tồn tại');
         }
         else {
            return WorkSpace::create([
               "IDUser" => $data["IDUser"],
               "WorkSpaceName" => $data["WorkSpaceName"],
               "WorkSpaceDescription" => $data["WorkSpaceDescription"],
            ]);
         }
      }
   }

   public function findWorkSpace($field, $value)
   {
      $workSpace = WorkSpace::where($field, $value)
         ->where('IsDeleted', false)
         ->first();

      if (!$workSpace) {
         return null;
         //throw new Exception('Không tìm thấy WorkSpace');
      }

      return $workSpace;
   }
}