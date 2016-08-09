<?php

namespace App;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class User extends Model implements Authenticatable
{
	use \Illuminate\Auth\Authenticatable;

	public function tournaments() {
		return $this->hasMany('App\Tournament');
	}

	public function notifications() {
    	return $this->hasMany('App\Notification');
	}

	public function newNotification() {
	    $notification = new Notification;
	    $notification->user()->associate($this);
	 
    	return $notification;
	}
}