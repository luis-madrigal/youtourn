<?php
namespace App\Http\Controllers;

use App\User;
use App\Tournament;
use App\Notification;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;

use Log;

class UserController extends Controller {

    public function getRegister() {
        return view('registration');
    }

    public function postSignUp(Request $request) {
        $this->validate($request, [
            'firstname' => 'required|max:120',
            'lastname' => 'required|max:120',
            'email' => 'required|email|unique:users',
            'username' => 'required|unique:users|max:30',
            'password' => 'required|min:6',
            'sex' => 'required'
        ]);

        $email = $request['email'];
        $firstname = $request['firstname'];
        $lastname = $request['lastname'];
        $password = bcrypt($request['password']);
        $username = $request['username'];
        $sex = $request['sex'];
        $time = strtotime($request['birthdate']);

        $user = new User();
        $user->username = $username;
        $user->email = $email;
        $user->first_name = $firstname;
        $user->last_name = $lastname;
        $user->password = $password;
        $user->gender = $sex;
        $user->birthday = date('Y-m-d',$time);

        $user->save();

        Auth::login($user);
        
        return redirect()->route('home');
    }

    public function postSignIn(Request $request) {
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required'
        ]);

        $remember = Input::get('remember');

        if(Auth::attempt(['username' => $request['username'], 'password' => $request['password']])) {
            if(!empty($remember))
                Auth::login(Auth::user(), true);
            else
                Auth::login(Auth::user(), false);
            return redirect()->route('home');
        }
        return redirect()->route('register')->with(['message' => 'Your input doesn\'t seem to match our records. Please try again.']);
    }

    public function getLogout() {
        Auth::logout();

        return redirect()->route('register');
    }

    public function getUserPage($user_id) {
        $user = User::where('id', $user_id)->first();
        $tournamentsCreated = Tournament::where('user_id', $user_id)
                                    ->where('deleted', false)->get();
        $notifications = Notification::where('source_id', $user_id)->where('type', 'Follow')->get();

        $tournamentsFollowed = [];

        for ($i=0; $i < count($notifications); $i++) { 
            $tournamentsFollowed[] = Tournament::where('id', $notifications[$i]->object_id)->first();
        }

        return view('profile', ['user' => $user, 'tournamentsCreated' => $tournamentsCreated, 'tournamentsFollowed' => $tournamentsFollowed]);
    }

    public function postEditAccount(Request $request) {
        $this->validate($request, [
            'firstname' => 'required|max:120',
            'lastname' => 'required|max:120'
        ]);

        $user = Auth::user();

        if($user->email != $request['email']) {
            $this->validate($request, [
                'email' => 'required|unique:users|email'
            ]);
        }

        
        $user->first_name = $request['firstname'];
        $user->last_name = $request['lastname'];
        $user->email = $request['email'];
        $user->description = $request['description'];
        $user->update();

        return redirect()->back();
    }

    public function postChangePic(Request $request) {
        $user = Auth::user();

        $file = $request->file('image');
        $filename = $user->first_name . '-' . $user->id . '.jpg';

        Log::info($file);

        if($file) {
            Storage::disk('local')->put($filename, File::get($file));
        }
        return redirect()->back();
    }

    public function getUserImage($filename) {
        $file = Storage::disk('local')->get($filename);

        return new Response($file, 200);
    }
}
