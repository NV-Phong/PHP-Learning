<?php
namespace WorkSpace\Service;

use Exception;
use WorkSpace\Model\Notification;
use WorkSpace\Model\TeamMember;
use WorkSpace\Model\User;

class NotificationService
{
    protected $notificationModel;
    protected $teamMemberModel;
    protected $userModel;

    public function __construct(Notification $notificationModel, TeamMember $teamMemberModel, User $userModel)
    {
        $this->notificationModel = $notificationModel;
        $this->teamMemberModel = $teamMemberModel;
        $this->userModel = $userModel;
    }

    // Gửi lời mời vào team
    public function sendTeamInvite($IDTeam, $Email, $Message, $IDUser)
    {
        try {
            // Kiểm tra quyền của người gửi lời mời
            $teamMember = $this->teamMemberModel
                ->where([
                    ['IDTeam', $IDTeam],
                    ['IDUser', $IDUser],
                    ['RoleInTeam', 'Leader'],
                    ['IsDeleted', false]
                ])
                ->first();

            if (!$teamMember) {
                throw new Exception('Chỉ có Leader của team mới được gửi lời mời');
            }

            // Kiểm tra xem đã có lời mời chưa
            $existingInvite = $this->notificationModel
                ->where([
                    ['IDTeam', $IDTeam],
                    ['Email', $Email],
                    ['IsDeleted', false]
                ])
                ->first();

            if ($existingInvite) {
                // Nếu đã có lời mời pending, không cho tạo mới
                if ($existingInvite->Status === 'pending') {
                    throw new Exception('Đã tồn tại lời mời cho email này');
                }
                
                // Nếu đã từ chối, cập nhật lại status và message
                if ($existingInvite->Status === 'rejected') {
                    $existingInvite->Status = 'pending';
                    $existingInvite->Message = $Message;
                    $existingInvite->save();
                    return $existingInvite;
                }
            }

            // Tạo thông báo mới
            $notification = new Notification([
                'IDTeam' => $IDTeam,
                'Email' => $Email,
                'Message' => $Message,
                'Status' => 'pending'
            ]);

            $notification->save();

            // Load thông tin team
            $notification->load(['team' => function($query) {
                $query->select('IDTeam', 'TeamName');
            }]);

            return $notification;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    // Lấy danh sách thông báo của user
    public function getUserNotifications($Email)
    {
        try {
            $notifications = $this->notificationModel
                ->with(['team' => function($query) {
                    $query->select('IDTeam', 'TeamName');
                }])
                ->where([
                    ['Email', $Email],
                    ['IsDeleted', false]
                ])
                ->orderBy('CreatedAt', 'desc')
                ->get();

            return $notifications;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    // Xử lý phản hồi lời mời
    public function handleInviteResponse($IDNotification, $Status, $IDUser)
    {
        try {
            // Lấy thông tin notification
            $notification = $this->notificationModel
                ->where([
                    ['IDNotification', $IDNotification],
                    ['IsDeleted', false]
                ])
                ->first();

            if (!$notification) {
                throw new Exception('Không tìm thấy thông báo');
            }

            // Lấy thông tin user
            $user = $this->userModel
                ->where([
                    ['IDUser', $IDUser],
                    ['IsDeleted', false]
                ])
                ->first();

            if (!$user) {
                throw new Exception('Không tìm thấy người dùng');
            }

            // Kiểm tra email của user có trùng với email trong notification không
            if ($user->Email !== $notification->Email) {
                throw new Exception('Bạn không có quyền xử lý lời mời này');
            }

            // Cập nhật trạng thái thông báo
            $notification->Status = $Status;
            $notification->save();

            // Nếu chấp nhận lời mời, thêm vào team member
            if ($Status === 'accepted') {
                // Kiểm tra xem đã là thành viên của team chưa
                $existingMember = $this->teamMemberModel
                    ->where([
                        ['IDTeam', $notification->IDTeam],
                        ['IDUser', $IDUser],
                        ['IsDeleted', false]
                    ])
                    ->first();

                if ($existingMember) {
                    throw new Exception('Bạn đã là thành viên của team này');
                }

                // Thêm vào team member
                $teamMember = new TeamMember([
                    'IDTeam' => $notification->IDTeam,
                    'IDUser' => $IDUser,
                    'RoleInTeam' => 'Member'
                ]);

                $teamMember->save();
            }

            return $notification;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}