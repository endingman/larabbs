<?php

namespace App\Models;

use Auth;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable {
        notify as laravelNotify;
    }

    use HasRoles;

    function notify($instance)
    {
        // 如果要通知的人是当前用户，就不必通知了！
        if ($this->id == Auth::id()) {
            return;
        }

        $this->increment('notification_count');
        $this->laravelNotify($instance);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'introduction', 'avatar',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    function topics()
    {
        return $this->hasMany(Topic::class);
    }

    function isAuthorOf($model)
    {
        return $this->id == $model->user_id;
    }

    function replies()
    {
        return $this->hasMany(Reply::class);
    }

    function markAsRead($value = '')
    {
        $this->notification_count = 0;
        $this->save();
        $this->unreadNotifications->markAsRead();

    }
}
