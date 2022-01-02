<?php

namespace App\Http\Controllers;

use App\Models\followers;
use App\Models\User;
use Illuminate\Http\Request;

class FollowersController extends Controller
{
    public function index($id)
    {
        //Check if follower is not auth user
        if(auth()->user()->id == $id) return back();

        //Check to route auth user to follow or unfollow a user
        if(Followers::where("follower_id", "=", auth()->user()->id)->where("user_id", "=", $id)->count() > 0) $this->destroy($id);
        else $this->store($id);

        return back();
    }

    //Add a like to a post
    public function store($id)
    {
        Followers::create(["follower_id" => auth()->user()->id, "user_id" => $id]);

        //Store the activity
        $activity = new ActivitiesController();
        $activity->store("Started following ". User::where("id", "=", $id)->get()[0]->firstname);
    }

    //Delete a like or unlike post
    public function destroy($id)
    {
        Followers::where("follower_id", "=", auth()->user()->id)->where("user_id", "=", $id)->delete();
    }
}
