<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Log;

use App\User;
use App\Tournament;
use App\Notification;
use App\Http\Requests;

use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function getNotifications($user_id) {
        $user = User::find($user_id);
        $notifications = $user->notifications()->orderBy('created_at', 'desc')->get();

        return new Response(['notifications' => $notifications], 200);
    }

    public function getIfFollowingTournament($user_id, $tournament_id) {
    	$result = Notification::where('user_id', $user_id)
    							->where('type', 'Follow')
    							->where('object_id', $tournament_id)->first();
    	if($result != null) {
    		return true;
    	} else {
    		return false;
    	}
    }

    public function postFollowNotification(Request $request) {
    	$tournament_id = $request['tournamentId'];
    	$tournament = Tournament::find($tournament_id);
    	$tournamentOwner = User::where('id', $tournament->user_id)->first();

    	$resultFollow = Notification::where('user_id', $tournamentOwner->id)
                                ->where('source_id', $request->user()->id)
    							->where('type', 'Follow')
    							->where('object_id', $tournament->id)->first();

        $deleted = false;
    	if($resultFollow != null) {
            $resultFollow->delete();
            $deleted = true;
    		return response()->json(['message' => 'You are not following <b>' . $tournamentOwner->username . '\'s ' . $tournament->name . '</b> tournament anymore!', 'deleted' => $deleted], 200);
    	} 

    	$tournamentOwner->newNotification()
                        ->withSource($request->user()->id)
    					->withType('Follow')
    					->withSubject('Your tournament has been followed')
    					->withBody('<b>' . $request->user()->username . '</b> has followed your <b>' . $tournament->name . '</b> tournament!')
    					->regarding($tournament)
    					->deliver();

    	return response()->json(['message' => 'You are now following <b>' . $tournamentOwner->username . '\'s ' . $tournament->name . '</b> tournament!', 'deleted' => $deleted], 200);
    }

    public function postReadNotifications(Request $request) {
        $user = Auth::user();

        $userNotifications = Notification::where('user_id', $user->id)->where('is_read', false)->get();

        foreach ($userNotifications as $notification) {
            $notification->is_read = true;
            $notification->update();
        }

        return $userNotifications;
    }
}