<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {   
 
        //Validate request data
        $request->validate([
            "firstname" => "required|max:225",
            "lastname" => "required|max:225",
            "email" => "required|email",
            "password" => "required|min:8",
            "dob" => "required|date",
            "gender" => "required",
            "city" => "required",
            "country" => "required",
        ]);

        //Check if the user exist (Remember that the email should be unique)
        $user = User::where("email", "=", $request->email)->get();

        if($user->count() > 0){
            $validationError = \Illuminate\Validation\ValidationException::withMessages([
                "duplicate email" => ["The email \"".$request->email."\" exist already!"],
            ]);

            throw $validationError; //Throw a validation error on this event
        }

        //Register the user
        User::create([
            "firstname" => $request->firstname,
            "lastname" => $request->lastname,
            "email" => $request->email,
            "password" => Hash::make($request->password),
            "dob" => $request->dob,
            "gender" => $request->gender === "on"? "male":"female",
            "city" => $request->city,
            "country" => $request->gender,
        ]);

        //Login the user
        auth()->attempt($request->only("email", "password"));

        //Redirect to the dashboard
        return redirect()->route("newsfeed");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Validte request
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if(auth()->attempt($request->only(['email', 'password']), $request->remember_me)) return redirect()->route("newsfeed");
        else return back()->with(['message' => 'Email or password incorrect']);
    }


    //Fetch users
    public function fetch(Request $request)
    {
        if(!isset($request->list) || count(json_decode($request->list)) == 0) return json_encode(["success" => false]);

        $list = json_decode($request->list);
        $data = [];

        foreach($list as $id){
            $user = User::where("id", "=", $id)->get();
            if($user->count() > 0) $data[$id] = $user[0];
        }

        return json_encode(["success" => true, "data" => $data]);
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

    //Upload profile image
    public function uploadProfileImage(Request $request)
    {


        if($request->file('image') == null){
            //Send a response
            return json_encode(['success' => false]);
        }


                
        $mime = $request->file('image')->getMimeType();

        if(!preg_match('(image)', $mime)) return json_encode(['success' => false]);

        $ext = $request->file('image')->getClientOriginalExtension();


        $fileToStore = time() . "." . $ext;

        $request->file('image')->storeAs('public/images/profile',  $fileToStore);


        //Store the post 
        auth()->user()->update([
            "image" => $fileToStore
        ]);   

        //Send a response
        return json_encode(['success' => true]);
    }



    //Upload profile image
    public function uploadProfileCover(Request $request)
    {


        if($request->file('image') == null){
            //Send a response
            return json_encode(['success' => false]);
        }


                
        $mime = $request->file('image')->getMimeType();

        if(!preg_match('(image)', $mime)) return json_encode(['success' => false]);

        $ext = $request->file('image')->getClientOriginalExtension();


        $fileToStore = time() . "." . $ext;

        $request->file('image')->storeAs('public/images/cover',  $fileToStore);


        //Store the post 
        auth()->user()->update([
            "cover_image" => $fileToStore
        ]);   

        //Send a response
        return json_encode(['success' => true]);
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        auth()->logout();
        return redirect()->route("home");
    }
}
