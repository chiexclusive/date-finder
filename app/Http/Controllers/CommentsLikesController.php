<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommentsLikesController extends Controller
{

	public function __construct()
	{	
		//return action to redirect if the user is not logged in
		// if(auth()->user() == null || auth()->user() == "" || auth()->user() == undefined) return exit(json_encode(['success' => false, 'redirect'=> "login"]));
	}

    public function store(Request $request, $postId, $commentId)
    {
    	if($postId == null || $commentId == null) return json_encode(['success' => false]);

    	$likes = auth()->user()->commentLikes()->where([
    		['post_id', '=', $postId],
    		['comments_id', '=', $commentId]
   		]);

   		if($likes->get()->count() > 0){
   			$likes->delete();
   		}else{

	    	auth()->user()->commentLikes()->create([
	    		'post_id' => $postId,
	    		'comments_id' => $commentId
	   		]);

	   		//Store the activity
	        $activity = new ActivitiesController();
	        $activity->store("Liked a comment");
	    }

        return json_encode(['success' => true]);
    }
}
