<?php


namespace App\Http\Controllers;

use \App\Http\Controllers\ActivitiesController;

use Illuminate\Http\Request;

class LikesController extends Controller
{
    public function index($id)
    {
        //Check if the auth user has like before
        if(auth()->user()->likes()->where("post_id", "=", $id)->count() > 0) $this->destroy($id);
        else $this->store($id);

        return back();
    }

    //Add a like to a post
    public function store($id)
    {
        auth()->user()->likes()->create(["post_id" => $id]);

        //Store the activity
        $activity = new ActivitiesController();
        $activity->store("Liked a post");
    }

    //Delete a like or unlike post
    public function destroy($id)
    {
        auth()->user()->likes()->where("post_id", "=", $id)->delete();
    }
}
