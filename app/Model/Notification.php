<?php
namespace WorkSpace\Model;

class Notification extends Entity
{
    protected $table = 'NOTIFICATION';
    protected $primaryKey = 'IDNotification';
    protected $fillable = [
        'IDTeam',
        'Email',
        'Message',
        'Status',
        'CreatedAt',
        'IsDeleted'
    ];
    protected $attributes = [
        'Status' => 'pending'
    ];

    public function team()
    {
        return $this->belongsTo(Team::class, 'IDTeam', 'IDTeam');
    }
}