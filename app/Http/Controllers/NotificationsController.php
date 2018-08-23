<?php

namespace App\Http\Controllers;

use Auth;

class NotificationsController extends Controller
{
    public function _construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $notifications = Auth::user()->notifications()->paginate(20);

        // 标记为已读，未读数量清零
        Auth::user()->markAsRead();

        return view('Notifications.index', compact('notifications'));
    }
}
