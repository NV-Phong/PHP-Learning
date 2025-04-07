<?php
namespace WorkSpace\Controller;

use WorkSpace\Service\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Exception;

class NotificationController
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    // Gửi lời mời vào team
    public function sendTeamInvite(Request $request): JsonResponse
    {
        try {
            $IDTeam = $request->input('IDTeam');
            $Email = $request->input('Email');
            $Message = $request->input('Message');
            $IDUser = $request->attributes->get('USER')['IDUser'];
            // print_r($IDUser);

            if (!$IDTeam || !$Email || !$Message) {
                return new JsonResponse(['error' => 'Thiếu thông tin bắt buộc'], 400);
            }

            $notification = $this->notificationService->sendTeamInvite($IDTeam, $Email, $Message, $IDUser);
            return new JsonResponse($notification);
        } catch (Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 400);
        }
    }

    // Lấy danh sách thông báo của user
    public function getUserNotifications(Request $request, $Email): JsonResponse
    {
        try {
            if (empty($Email)) {
                return new JsonResponse([
                    'success' => false,
                    'message' => 'Thiếu Email'
                ], 400);
            }

            $notifications = $this->notificationService->getUserNotifications($Email);
            
            return new JsonResponse([
                'success' => true,
                'data' => $notifications
            ], 200);
        } catch (Exception $e) {
            return new JsonResponse([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    // Xử lý phản hồi lời mời
    public function handleInviteResponse(Request $request): JsonResponse
    {
        try {
            $IDNotification = $request->input('IDNotification');
            $Status = $request->input('Status');
            $IDUser = $request->attributes->get('USER')['IDUser'];

            if (!$IDNotification || !$Status) {
                return new JsonResponse(['error' => 'Thiếu thông tin bắt buộc'], 400);
            }

            if (!in_array($Status, ['accepted', 'rejected'])) {
                return new JsonResponse(['error' => 'Trạng thái không hợp lệ'], 400);
            }

            $notification = $this->notificationService->handleInviteResponse($IDNotification, $Status, $IDUser);
            return new JsonResponse($notification);
        } catch (Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 400);
        }
    }
}