<?php

namespace App\Http\Controllers;

use App\Models\Comments;
use App\Http\Controllers\ActivitiesController;

use Illuminate\Http\Request;

class CommentsController extends Controller
{


	public function __construct()
	{	
		//return action to redirect if the user is not logged in
		if(auth()->user() == null || auth()->user() == "" || auth()->user() == undefined) return exit(json_encode(['success' => false, 'redirect'=> "login"]));
	}


    
    //Store comment
    public function store(Request $request)
    {
    	$postId = $request->route('postId');
    	$comment = $request->comment;

    	if($postId == null || $comment == null) return json_encode(['success' => false]);

    	auth()->user()->comments()->create(["post_id" => $postId, "comment" => $comment]);

    	//Store the activity
        $activity = new ActivitiesController();
        $activity->store("Commented a post");

    	return json_encode(['success' => true]);
    }


    //Get comments
    public function getComment(Request $request, $id)
    {
    	if($id == null) return json_encode(['success' => false]);

    	$comments = Comments::where("post_id", "=", $id)->orderBy("created_at", "desc")->get();
    	$users = [];
    	$likes = [];

    	foreach($comments as $comment)
    	{
    		$users[$comment->user()->get()[0]->id] = $comment->user()->get()[0];
    		$likes[$comment->id] = $comment->likes()->get();

    	}



    	return json_encode(['success' => true, 'data' => ['comments' => $comments, 'users' => $users, 'likes' => $likes]]);

    }
}
