<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationResource;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Notification;

class NotificationsController extends Controller
{
    //
    public function index(Request $request ) {

        $user = $request->user();

        $notifications = $user->notifications()->paginate(10);

        return NotificationResource::collection($notifications);
    }

    //未读通知
    public function unreadStatistic(Request $request) {
        $user = $request->user();
        $data = [
            'unread_count' => $user->notification_count
        ];

        return response()->json($data,200);
    }

    //标记所有通知为已读
    public function markAllAsRead(Request $request) {
        $user = $request->user();
        $user->markAsRead();

        return response(null,204);
    }

    public function markOneAsRead(DatabaseNotification $notification,Request $request ) {

        $user = $request->user();
        //权限验证,通知是否属于该用户
        //暂时没找到怎么验证
        if (true){
            //避免统计为0的情况
            if ($user->notification_count){
                //统计减一
                $user->decrement('notification_count');
                $notification->markAsRead();
            }

            return response(null,200);
        }

       return response(null,403);




    }
}
