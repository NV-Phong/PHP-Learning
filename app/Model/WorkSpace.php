<?php
namespace WorkSpace\Model;

class WorkSpace extends Entity
{
   protected $table = 'WORKSPACE';
   protected $primaryKey = 'IDWorkspace';
   public $timestamps = false;
   protected $fillable = ['IDUser', 'WorkSpaceName', 'WorkSpaceDescription', 'IsDeleted'];
   protected $attributes = [
      'IsDeleted' => false,
   ];
}