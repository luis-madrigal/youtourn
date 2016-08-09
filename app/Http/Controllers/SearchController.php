<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Input;

use App\Http\Requests;
use App\User;
use App\Tournament;

use Log;

class SearchController extends Controller
{
    public function autocomplete(){
		$term = Input::get('term');
		
		$results = array();
		
		$query1 = User::where('first_name', 'LIKE', '%'.$term.'%')
						->orWhere('last_name', 'LIKE', '%'.$term.'%')
						->orWhere('username', 'LIKE', '%'.$term.'%')
						->get();
		$query2 = Tournament::where('name', 'LIKE', '%'.$term.'%')->get();

		foreach ($query1 as $query){
		    $results[] = [ 'id' => $query->id, 'value' => $query->first_name.' '.$query->last_name.' ('.$query->username.')', 'category' => 'Users' ];
		}

		foreach ($query2 as $query){
		    $results[] = [ 'id' => $query->id, 'value' => $query->name.' ('.$query->type.')', 'category' => 'Tournaments' ];
		}

		if($query1->isEmpty() && $query2->isEmpty()) {
			$results[] = ['value' => 'There doesn\'t seem to be anything here...', 'category' => 'Nothing'];
		}

		return $results;
	}

}
