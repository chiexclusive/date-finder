<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Followers;
use App\Models\Friends;
use App\Models\Post;
use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    //Index profile page
    public function index (Request $request) 
    {
    	$id = $request->route('id');
    	$user = User::where("id", "=", $id)->get();

    	if($user->count() > 0) $user = $user[0];

	    $followers = $user->count() > 0 ? Followers::where('user_id', "=", $id)->orderBy("created_at", "desc")->get() : null;


	    $posts = $user->count() > 0 ? $user->posts()->where("user_id", "=", $id)->orderBy("created_at", "desc")->paginate(10): null;

        //Identify user
        $targetUser = auth()->user() == null ? 'guest' : auth()->user()->id;
        $posts = null;

        //Fetch post based on visibility of the post
        if($targetUser == 'guest') $posts = Post::where("user_id", "=", $id)->where("visibility", "=", "public")->orderBy("created_at", "desc")->paginate(10);
        else{
            $posts = Post::where([["visibility", "=", "me"], ["user_id", "=", auth()->user()->id], ["user_id", "=", $id]]);
            $posts = $posts->orWhere([["visibility", "=", "public"], ["user_id", "=", $id]]);
            $posts = $posts->orWhere([["visibility", "=", "friends"], ["user_id", "=", auth()->user()->id], ["user_id", "=", $id]]);
            $posts = $posts->orderBy("created_at", "desc")->paginate(10);
        }


        $friends = auth()->user() !== null ? auth()->user()->friends()->orderBy("created_at", "desc")->get() : null;




        $activities = User::where("id", "=", $id)->get()[0]->activities()->orderBy("created_at", "desc")->paginate(10);


	    return view("timeline")->with(["title" => "User Timeline | Date Finder", "type" => "profile", 'page' => 'timeline', 'id' => $id, 'followers' => $followers, 'user' => $user, 'posts' => $posts, 'friends' => $friends, 'activities' => $activities]);
    }


    public function getEditPage ($request, $type)
    {
    	$id = $request->route('id');
    	$user = User::where("id", "=", $id)->get();

    	if($user->count() > 0) $user = $user[0];

	    $followers = $user->count() > 0 ? Followers::where('user_id', "=", $id)->orderBy("created_at", "desc")->get() : null;

        $friends = auth()->user() !== null ? auth()->user()->friends()->orderBy("created_at", "desc")->get() : null;


        $activities = User::where("id", "=", $id)->get()[0]->activities()->orderBy("created_at", "desc")->paginate(10);

	    return view("editProfile")->with(["title" => "Edit User Profile | Date Finder", "type" => "profile", 'page' => 'edit', 'id' => $id, 'followers' => $followers, 'user' => $user, 'friends' => $friends, "sub_type" => $type, 'activities' => $activities]);
    }


    public function update (Request $request, $id)
    {   
        // dd($request->type);

    	//Handle profile update
        switch($request->type){
            case "basic":
                 $request->validate([
                    "firstname" => "required|max:225",
                    "lastname" => "required|max:225",
                    "email" => "required|email",
                    "dob" => "required|date",
                    "gender" => "string|required",
                    "city" => "string|required",
                    "country" => "string|required",
                ]);
                

                User::where("id", "=", $id)
                ->update(
                    $request->only(["firstname", "lastname", "email", "dob", "gender", "city", "country", "bio"])
                );

                break;

            case "interests":

                $request->validate([
                    "interest" => "string|required|max:225",
                    "interest_age_range" => "string|required|max:225",
                ]);
                

                User::where("id", "=", $id)
                ->update(
                    $request->only(["interest", "interest_age_range"])
                );

                break;

            case "language":

                $request->validate([
                    "language" => "string|required|max:10",
                ]);
                // dd("sdsdds");

                User::where("id", "=", $id)
                ->update(
                    $request->only(["language"])
                );

                return back()->with("data", ["message" => "Language updated successfully.", "success" => true]);

                break;

            case "password":

                $request->validate([
                    "password" => "string|required|min:6",
                ]);

                User::where("id", "=", $id)
                ->update(
                    ["password" => Hash::make($request->password)]
                );

                return back()->with("data", ["message" => "Password updated successfully.", "success" => true]);

                break;
            default:
                return back();

        }

        return back()->with("data", ["message" => "Profile updated successfully.", "success" => true]);
    }


    //Get the about page of user
    public function getAboutPage (Request $request) 
    {
        $id = $request->route('id');

        $user = User::where("id", "=", $id)->get();

        if($user->count() > 0) $user = $user[0];

        $followers = $user->count() > 0 ? Followers::where('user_id', "=", $id)->orderBy("created_at", "desc")->get() : null;

        $friends = auth()->user() !== null ? auth()->user()->friends()->orderBy("created_at", "desc")->get() : null;
        

        $activities = User::where("id", "=", $id)->get()[0]->activities()->orderBy("created_at", "desc")->paginate(10);

        return view("aboutUser")->with(["title" => "About User | Date Finder", "type" => "profile", 'page' => 'about', 'id' => $id, 'followers' => $followers, 'user' => $user, 'friends' => $friends, 'activities' => $activities]);
    }


    //Get the friends page
    public function getFriendsPage ($id, Friends $friend) 
    {

        $user = User::where("id", "=", $id)->get();

        if($user->count() > 0) $user = $user[0];


        $followers = $user->count() > 0 ? Followers::where('user_id', "=", $id)->orderBy("created_at", "desc")->get() : null;

        $friends = auth()->user() !== null ? auth()->user()->friends()->orderBy("created_at", "desc")->get() : null;


        $friend = $friend->where("friend_id", "=", $id)->get();

        // dd($friend[0]->user()->get()[0]);

        $posts = $user->count() > 0 ? $user->posts()->where("user_id", "=", $id)->get(): null;

        $activities = User::where("id", "=", $id)->get()[0]->activities()->orderBy("created_at", "desc")->paginate(10);

        return view("userProfileFriends")->with(["title" => "User Friends | Date Finder", "type" => "profile", 'page' => 'friends', 'id' => $id, 'followers' => $followers, 'user' => $user, 'friends' => $friends, 'profile_friends' => $friend, 'activities' => $activities]);
    }


    //Get the followers page
    public function getFollowersPage ($id, User $user) 
    {

        $userDB = $user;

        $user = $user->where("id", "=", $id)->get();

        if($user->count() > 0) $user = $user[0];

        $followers = $user->count() > 0 ? Followers::where('user_id', "=", $id)->orderBy("created_at", "desc")->get() : null;

        $friends = auth()->user() !== null ? auth()->user()->friends()->orderBy("created_at", "desc")->get() : null;


        $friend = Friends::where("friend_id", "=", $id)->get();


        $posts = $user->count() > 0 ? $user->posts()->where("user_id", "=", $id)->get(): null;

        $activities = User::where("id", "=", $id)->get()[0]->activities()->orderBy("created_at", "desc")->paginate(10);

        return view("userProfileFollowers")->with(["title" => "User Followers | Date Finder", "type" => "profile", 'page' => 'followers', 'id' => $id, 'followers' => $followers, 'userDB' => $userDB, 'user' => $user, 'friends' => $friends, 'profile_friends' => $friend, 'activities' => $activities]);
    }
}
