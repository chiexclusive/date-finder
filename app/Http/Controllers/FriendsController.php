<?php

namespace App\Http\Controllers;

use App\Models\Friends;
use App\Models\Followers;
use App\Models\User;
use Illuminate\Http\Request;

class FriendsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        //Check if friend is not auth user
        if(auth()->user()->id == $id) return back();

        //Check to route auth user send friend request or delete friend request
        if(Friends::where("friend_id", "=", $id)->where("user_id", "=", auth()->user()->id)->where("status", "=", 1)->count() > 0) $this->unfriend($id);
        else if(Friends::where("friend_id", "=", $id)->where("user_id", "=", auth()->user()->id)->where("status", "=", 0)->count() > 0)$this->cancelRequest($id);
        else $this->store($id);

        return back();
    }

    //Store and send friend request
    public function store($id)
    {

        Friends::create(["friend_id" => $id, "user_id" => auth()->user()->id, "status" => false]);
    }

    //Delete request when request has not been accepted
    public function cancelRequest($id)
    {
        Friends::where("friend_id", "=", $id)->where("user_id", "=", auth()->user()->id)->where("status", "=", 0)->delete();
    }


    //Delete request when request has been accepted
    public function unfriend($id)
    {
        Friends::where("friend_id", "=", $id)->where("user_id", "=", auth()->user()->id)->where("status", "=", 1)->delete();
        Friends::where("user_id", "=", $id)->where("friend_id", "=", auth()->user()->id)->where("status", "=", 1)->delete();
        return back();
    }


    //Reject request
    public function reject($id)
    {
        Friends::where("friend_id", "=", auth()->user()->id)->where("user_id", "=", $id)->where("status", "=", 0)->delete();
        return back();
    }

    //Accept request
    public function accept($id)
    {
        Friends::where("friend_id", "=", auth()->user()->id)->where("user_id", "=", $id)->where("status", "=", 0)->update(["status" => true]);
        Friends::create(["friend_id" => $id, "user_id" => auth()->user()->id, "status" => true]);
        return back();
    }


    //Get dash board friends
    public function getDashboardFriends ()
    {

        $user = auth()->user() == null ? 'guest': auth()->user()->id;

        $followers = Followers::all();

        $friends = Friends::where("friend_id", "=", auth()->user()->id)->get();

        $friend_request = (auth()->user() !== null) ? Friends::where("friend_id", "=", auth()->user()->id)->where("status", "=", 0)->get(): null;

        //Fetch suggestions
        $suggestions = [];
        if($user !== 'guest'){
            //Get Gender
            $allUsers = User::where("id", "!=", auth()->user()->id)->get();
            $counter = 0;

            foreach($allUsers as $match)
            {
                // age, location, mb_language()
                $gender = auth()->user()->interst !== null ? auth()->user()->interst == "*" ? ['male', 'female'] : [auth()->user()->interest]: [];
                $range = [
                    "18-25" => [18, 25],
                    "25-50" => [25, 50],
                    "50 and above" => [50, 100],
                ];
                $ageRange = array_key_exists(auth()->user()->interest_age_range, $range) ? $range[auth()->user()->interest_age_range]: [0, 0];
                $country = auth()->user()->country;
                $city = auth()->user()->city;
                $language = auth()->user()->language;

                //match 
                $matchAge = date('Y') - date('Y', strtotime($match->dob));

                if(array_search($match->gender, $gender) && 
                    $range[0] <= $matchAge && 
                    $range[1] >= $matchAge &&
                    $country == $match->country || 
                    $city == $match->city ||
                    $language == $match->language &&
                    $counter <= 20

                ){
                    //Make sure that the suggestion is not your friend and no request has been sent
                    $testFriend = Friends::where([["user_id", "=", auth()->user()->id], ['friend_id', "=", $match->id]])->orWhere([["friend_id", "=", auth()->user()->id], ["user_id", "=", $match->id]]);

                    if($testFriend->count()  == 0 ){
                        array_push($suggestions, $match);
                        $counter++;
                    }

                    
                }
            }
        }
        // dd($friend_request[0]->user()->get());
        return view("dashboardFriends")->with(["title" => "My Friends | News Feed", "type" =>  "friends", "followers" => $followers, 'friend_request' => $friend_request, 'friends' => $friends, 'suggestions' => $suggestions]);
    }

}
