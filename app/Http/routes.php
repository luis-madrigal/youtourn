<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/get_notifications/{user_id}', [
	'uses' => 'NotificationController@getNotifications',
	'as' => 'get.notifs'
]);

Route::post('/set_notifications_read', [
	'uses' => 'NotificationController@postReadNotifications',
	'as' => 'set.notifs.read'
]);

Route::post('/follow_tournament', [
	'uses' => 'NotificationController@postFollowNotification',
	'as' => 'follow.notif'
]);

Route::get('/create_tournament', [
	'uses' => 'TournamentController@getCreateTournament',
	'as' => 'create.tournament',
	'middleware' => 'auth'
]);

Route::post('/save_tournament', [
	'uses' => 'TournamentController@postCreateTournament',
	'as' => 'save.tournament'
]);

Route::post('/upload_tournamentpic', [
	'uses' => 'TournamentController@postUploadTournamentPicture',
	'as' => 'upload.tournament.pic'
]);

Route::get('/tournamentimage/{filename}', [
	'uses' => 'TournamentController@getTournamentImage',
	'as' => 'tournament.image'
]);

Route::post('/edit_tournament', [
	'uses' => 'TournamentController@postEditTournament',
	'as' => 'edit.tournament'
]);

Route::post('/delete_tournamanet', [
	'uses' => 'TournamentController@postDeleteTournament',
	'as' => 'delete.tournament'
]);

Route::post('/undo_delete_tournamanet', [
	'uses' => 'TournamentController@postUndoDeleteTournament',
	'as' => 'undo.delete.tournament'
]);

Route::post('/set_winner_tournamanet', [
	'uses' => 'TournamentController@postSetWinnerTournament',
	'as' => 'set.winner.tournament'
]);

Route::get('/tournament_pool', [
	'uses' => 'TournamentController@getTournamentPool',
	'as' => 'tournament.pool'
]);

Route::get('/tournament_page/{tournament_id}', [
	'uses' => 'TournamentController@getTournamentPage',
	'as' => 'tournament.page'
]);

Route::get('/profile/{user_id}', [
	'uses' => 'UserController@getUserPage',
	'as' => 'user.page'
]);

Route::post('/edit_account', [
	'uses' => 'UserController@postEditAccount',
	'as' => 'user.edit'
]);

Route::post('/change_profpic', [
	'uses' => 'UserController@postChangePic',
	'as' => 'change.profpic'
]);

Route::get('/userimage/{filename}', [
	'uses' => 'UserController@getUserImage',
	'as' => 'account.image'
]);

Route::get('/register', [
	'uses' => 'UserController@getRegister',
	'as' => 'register'
]);

Route::post('/signup', [
	'uses' => 'UserController@postSignUp',
	'as' => 'signup'
]);

Route::post('/signin', [
	'uses' => 'UserController@postSignIn',
	'as' => 'signin'
]);

Route::get('/logout', [
	'uses' => 'UserController@getLogout',
	'as' => 'logout'
]);

Route::get('/search/autocomplete', [
	'uses' => 'SearchController@autocomplete',
	'as' => 'search.autocomplete'
]);
