<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Followers;
use App\Models\Friends;

class PostsController extends Controller
{   

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        //Identify user
        $user = auth()->user() == null ? 'guest' : auth()->user()->id;
        $posts = null;

        //Fetch post based on visibility of the post
        if($user == 'guest') $posts = Post::where("visibility", "=", "public")->orderBy("created_at", "desc")->paginate(10);
        else{
            $friends = Friends::where("user_id", "=", auth()->user()->id)->get();
            $posts = Post::where([["visibility", "=", "me"], ["user_id", "=", auth()->user()->id]]);
            $posts = $posts->orWhere("visibility", "=", "public");
            $posts = $posts->orWhere([["visibility", "=", "friends"], ["user_id", "=", auth()->user()->id]]);
            foreach($friends as $friend){
                $posts = $posts->orWhere([["visibility", "=", "friends"], ["user_id", "=", $friend->friend_id]]);
            }
            $posts = $posts->orderBy("created_at", "desc")->paginate(10);
            // dd($posts[3]->comments()->get()[0]->user()->get());
        }

        $followers = Followers::all();

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

        $friend_request = (auth()->user() !== null) ? Friends::where("friend_id", "=", auth()->user()->id)->where("status", "=", 0)->get(): null;
        // dd($friend_request[0]->user()->get());
        return view("newsfeed")->with(["title" => "Date Finder | News Feed", "type" =>  "posts", "posts" => $posts, "followers" => $followers, 'friend_request' => $friend_request, 'suggestions' => $suggestions]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        //Validate request data
        $this->validate($request, [
            'message' => 'string|nullable',
        ]);

        if(!isset($request->message) && $request->files->count() == 0){
            //Send a response
            return json_encode(['success' => false, 'message' => "Post publish failed !"]);
        }

        $imageNames = [];
        $videoNames = [];


        if($request->files->count() !== 0){

            foreach($request->files as $key => $file){
                
                $mime = $request->file($key)->getMimeType();
                $fileName = $request->file($key)->getClientOriginalName();
                $ext = $request->file($key)->getClientOriginalExtension();

                $imageName = preg_match('(image)', $mime) ? time().".".$ext : null;
                $videoName = !preg_match('(image)', $mime) ? time().".".$ext : null;

                if($imageName !== null) array_push($imageNames, $imageName);
                if($videoName !== null) array_push($videoNames, $videoName);

                $fileToStore = $imageName === null ? $videoName : $imageName;

                $request->file($key)->storeAs('public',  $fileToStore);
            }

        }

        //Store the post 
        auth()->user()->posts()->create([
            "message" => $request->message,
            "image" => json_encode($imageNames),
            "video" => json_encode($videoNames),
            "visibility" => $request->postVisibility
        ]);   

        //Send a response
        return json_encode(['success' => true, 'message' => "Post successfully created"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Delete post
        $post = Post::where("id", "=", $id);
        $post->delete();
        return back();
    }
}
