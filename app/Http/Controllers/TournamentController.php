<?php

namespace App\Http\Controllers;

use Log;
use App\User;
use App\Tournament;
use App\Notification;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class TournamentController extends Controller
{
    public function getTournamentPool() {
        $tournaments = Tournament::all();

        $filter = Input::get('filter');
        $sortBy = Input::get('sortBy');

        if((empty($filter) || empty($sortBy)) || ($sortBy == 'created_at' && $filter == 'None'))
            $tournaments = Tournament::orderBy('created_at', 'desc')->get();
        else if($filter == 'None')
            $tournaments = Tournament::orderBy($sortBy)->get();
        else
            $tournaments = Tournament::where('type', $filter)->orderBy($sortBy)->get();

    	return view('tournament_pool', ['tournaments' => $tournaments, 'sortBy' => $sortBy, 'filter' => $filter]);
    }

    public function getTournamentPage($tournament_id) {
    	$tournament = Tournament::where('id', $tournament_id)->first();
        $message = "";
        $following = false;

        if(Auth::check()) {
            $result = Notification::where('user_id', $tournament->user_id)
                                ->where('source_id', Auth::user()->id)
                                ->where('type', 'Follow')
                                ->where('object_id', $tournament_id)->first();
            $following = $result != null;

            if(Auth::user()->id == $tournament->user_id) {
                $message = 'Creator';
            }
        }
        
    	return view('tournament_page', ['tournament' => $tournament, 'message' => $message, 'following' => $following]);
    }

    public function getCreateTournament() {
        return view('create_tournament');
    }

    public function postCreateTournament(Request $request) {
        
        $this->validate($request, [
            'name' => 'required',
        ]);

        $tournament = new Tournament();
        $tournament->name = $request['name'];
        $tournament->description = $request['description'];
        $tournament->type = $request['type'];
        $tournament->visibility = $request['visibility'];
        $tournament->tourn_data = $request['tourn_data'];

        $request->user()->tournaments()->save($tournament);

        $filename = $tournament->name . '-' . $tournament->id . '.jpg';

        if (Storage::disk('local')->has('placeholder.jpg')) {
            Storage::move('placeholder.jpg', $filename);
        }
 
        return response()->json(['message' => $tournament->id], 200);
    }

    public function postUploadTournamentPicture(Request $request) {
        $filename = 'placeholder.jpg';
        
        if (Input::hasFile('image'))
            Storage::disk('local')->put($filename, File::get($request['image']));
    }

    public function postEditTournament(Request $request) {
        $tournament = Tournament::find($request['tournamentId']);
        $tournament->tourn_data = $request['tourn_data'];
        $tournament->type = $request['tournamentType'];
        $tournament->update();

        $notifications = Notification::where('object_id', $tournament->id)->where('type', 'Follow')->get();

        foreach ($notifications as $notification) {
            $targetUser = User::where('id', $notification->source_id)->first();
            $targetUser->newNotification()
                        ->withSource($request->user()->id)
                        ->withType('Edit')
                        ->withSubject('The tournament your following has been edited.')
                        ->withBody('<b>' . $tournament->name . '</b> has been edited by <b>' . $request->user()->username .'</b>!')
                        ->regarding($tournament)
                        ->deliver();
        }
    }

    public function postDeleteTournament(Request $request) {
        $tournamentDeleted = $request['tournamentsDeleted'];
        $tournamentNames = [];
        for ($i=0; $i < count($tournamentDeleted); $i++) { 
            $tournament = Tournament::where('id', $tournamentDeleted[$i])->first();
            $tournament->deleted = true;
            $tournamentNames[] = $tournament->name;
            $tournament->update();
        }

        return $tournamentNames;
    }

    public function postUndoDeleteTournament(Request $request) {
        $tournamentDeleted = $request['tournamentsDeleted'];
        for ($i=0; $i < count($tournamentDeleted); $i++) { 
            $tournament = Tournament::where('id', $tournamentDeleted[$i])->first();
            $tournament->deleted = false;
            $tournamentNames[] = $tournament->name;
            $tournament->update();
        }
    }

    public function postSetWinnerTournament(Request $request) {
        $winner = $request['winner'];
        $tournament = Tournament::where('id', $request['tournament_id'])->first();
        $tournament->winner = $winner;
        $tournament->update();

        $notifications = Notification::where('object_id', $tournament->id)->where('type', 'Follow')->get();

        foreach ($notifications as $notification) {
            $targetUser = User::where('id', $notification->source_id)->first();
            $targetUser->newNotification()
                        ->withSource($request->user()->id)
                        ->withType('Winner')
                        ->withSubject('The tournament your following has been concluded.')
                        ->withBody('<b>' . $tournament->name . '</b> has finished with <b>' . $winner . '</b> being the winner.')
                        ->regarding($tournament)
                        ->deliver();
        }
    }

    public function getTournamentImage($filename) {
        Log::info($filename);
        $file = Storage::disk('local')->get($filename);

        return new Response($file, 200);
    }
}
