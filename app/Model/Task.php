<?php
namespace WorkSpace\Model;

class Task extends Entity
{
   protected $table = 'TASK';
   protected $primaryKey = 'IDTask';
   protected $fillable = ['IDProject', 'IDStatus', 'IDTag', 'IDAssignee', 'TaskName','TaskDescription', 'Priority', 'CreateAt', 'StartDay', 'EndDay', 'DueDay', 'IsDeleted'];
   protected $attributes = [
      'Priority' => 'Low',
    //  'CreateAt' => 'CURRENT_TIMESTAMP',
   ];
   protected $casts = [
      'CreateAt' => 'datetime',
  ];
   public function project()
   {
      return $this->belongsTo(Project::class, 'IDProject', 'IDProject');
   }

   public function status()
   {
      return $this->belongsTo(Status::class, 'IDStatus', 'IDStatus');
   }

   public function tag()
   {
      return $this->belongsTo(Tag::class, 'IDTag', 'IDTag');
   }

   public function assignee()
   {
      return $this->belongsTo(User::class, 'IDAssignee', 'IDUser');
   }

   public function attachments()
   {
      return $this->hasMany(TaskAttachment::class, 'IDTask', 'IDTask');
   }
}