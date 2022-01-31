<?php

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;


use App\Models\User;
use App\Models\Followers;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LikesController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\FollowersController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FriendsController;
use App\Http\Controllers\ChatsController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\CommentsLikesController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
*/


/**
 * Root Route
 */
Route::get('/', function (Request $request) {
    return view('landing')->with(["title" => "Date Finder | A Complete Social Network", "type" => "home", "uri" => $request->path(), 'registered' => $request->registered]);
})->name("home")->middleware("guest")->middleware("registered");


/**
 * Login page route
 */
Route::get('/login', function (Request $request) {
    return view('landing')->with(["title" => "Date Finder | Login", "type" => "home", "uri" => $request->path(),'registered' => $request->registered]);
})->name("login_page")->middleware("guest")->middleware("registered");


/**
 * Regisration page route
 */
Route::get('/register', function (Request $request) {
    return view('landing')->with(["title" => "Date Finder | Register", "type" => "home", "uri" => $request->path(),'registered' => $request->registered]);
})->name("register_page")->middleware("guest")->middleware("registered");


/**
 * Users Routes
 */
//Registration
Route::post("/users/register", [UsersController::class, 'create'])->name("register"); //Handle crud on users
//Login
Route::post('/users/login', [UsersController::class, "store"])->name("login");
//Logout
Route::post('/users/logout', [UsersController::class, 'destroy'])->name('logout');
//Follow a user
Route::post("/users/{id}/follow", [FollowersController::class, "index"])->name("user.follow")->middleware("auth");
//Add user
Route::post("/users/{id}/add", [FriendsController::class, "index"])->name("user.add")->middleware("auth");
//Accept a user request
Route::get("/users/{id}/accept", [FriendsController::class, "accept"])->name("user.accept")->middleware("auth");
//Reject a user request
Route::get("/users/{id}/reject", [FriendsController::class, "reject"])->name("user.reject")->middleware("auth");
//Fetch all users chat
Route::get("/users/{id}/chats", [ChatsController::class, "index"])->name("user.chats")->middleware("auth");
//Fetch specific user information
Route::post("/users/fetch", [UsersController::class, "fetch"])->name("user.fetch")->middleware("auth");
//Register chat message
Route::post("/users/chats/{id}/{receipient}/store", [ChatsController::class, "store"])->name("user.chats.send")->middleware("auth");
//Register chat message
Route::post("/users/chats/{chatId}/message/{msgId}/update", [ChatsController::class, "update"])->name("user.chats.update")->middleware("auth");
//Upload profile image
Route::post("/users/profile/image", [UsersController::class, "uploadProfileImage"])->name("user.profile.upload")->middleware("auth");
//Upload profile cover image
Route::post("/users/profile/cover", [UsersController::class, "uploadProfileCover"])->name("user.cover.upload")->middleware("auth");




/**
 * Post Feeds Route
 */
//Redirect to newsfeed
Route::get("/dashboard", function ()
{
    return redirect()->route("newsfeed");
});
Route::get("/dashboard/newsfeed", [PostsController::class, "index"])->name("newsfeed");
Route::post("/post", [PostsController::class, "store"])->name("post")->middleware("auth"); //Handle crud on posts
Route::delete("/post/{id}", [PostsController::class, "destroy"])->name("post.delete")->middleware("auth")->middleware("PostOwner");
Route::post("/post/{id}/like", [LikesController::class, "index"])->name("post.likes")->middleware("auth");


/**
 * Profile
 */
Route::get("/profile/{id}/timeline", [ProfileController::class, "index"])->name("timeline");

Route::get("/profile/{id}/about", [ProfileController::class, "getAboutPage"])->name("about_user");

Route::get("/profile/{id}/edit", function (Request $request) {
    $profile = new ProfileController();
    return $profile->getEditPage($request, "basic");
})->name("edit_profile")->middleware("auth")->middleware("ProfileOwner");

Route::put("/profile/{id}/edit", [ProfileController::class, "update"])->name("edit_profile")->middleware("auth")->middleware("ProfileOwner");

Route::get("/profile/{id}/edit/basic", function (Request $request) {
    $profile = new ProfileController();
    return $profile->getEditPage($request, "basic");
})->name("edit_profile_basic")->middleware("auth")->middleware("ProfileOwner");

Route::get("/profile/{id}/edit/langs", function (Request $request) {
    $profile = new ProfileController();
    return $profile->getEditPage($request, "language");
})->name("edit_profile_langs")->middleware("auth")->middleware("ProfileOwner");

Route::get("/profile/{id}/edit/password", function (Request $request) {
    $profile = new ProfileController();
    return $profile->getEditPage($request, "password");
})->name("edit_profile_password")->middleware("auth")->middleware("ProfileOwner");

Route::get("/profile/{id}/edit/interests", function (Request $request) {
    $profile = new ProfileController();
    return $profile->getEditPage($request, "interests");
})->name("edit_profile_interests")->middleware("auth")->middleware("ProfileOwner");

Route::get("/profile/{id}/friends", [ProfileController::class, "getFriendsPage"])->name("profile_friends");

Route::get("/profile/{id}/followers", [ProfileController::class, "getFollowersPage"])->name("profile_followers");



//Friends (Dashboard)
Route::get("/dashboard/friends", [FriendsController::class, "getDashboardFriends"])->name("friends")->middleware("auth");


//Messages (Dashboard)
Route::post("/dashboard/messages", [ChatsController::class, "getMessagePage"])->name("messages")->middleware("auth");


//Forgot password
Route::get("/forgot-password", function () {
    return view("forgot-password")->with(["title" => "Password Reset | Date Finder"]);
})->middleware("guest")->name("password.request");


//Forgot password with email
Route::post("/forgot-password", function (Request $request) {
    $request->validate([
        'email' => "email|required"
    ]);


    $status = Password::sendResetLink($request->only('email'));

    return $status == Password::RESET_LINK_SENT
            ? back()->with(['status' =>  __($status)])
            : back()->with(['emailError' => __($status)]);

})->middleware("guest")->name("password.email");


//Forgot password with password
Route::get("/forgot-password/{token}", function ($token) {
     return view("reset-password")->with(["title" => "Password Reset | Date Finder", "token" => $token]);
})->middleware("guest")->name("password.reset");



Route::post('/reset-password', function (Request $request) {
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:8|confirmed',
    ]);

    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function ($user, $password) {
            $user->forceFill([
                'password' => Hash::make($password)
            ])->setRememberToken(Str::random(60));

            $user->save();

            event(new PasswordReset($user));
        }
    );

    return $status === Password::PASSWORD_RESET
                ? redirect()->route('login')->with('status', __($status))
                : back()->with(['email' => __($status)]);
})->middleware('guest')->name('password.update');


//Register comment
Route::post("/post/{postId}/comment", [CommentsController::class, "store"])->name("comments.store");

//Get comment
Route::post("/post/{id}/comment/get", [CommentsController::class, "getComment"])->name("comments.get");


//Register commentlikes
Route::post("/post/{postId}/comment/{commentId}}/like", [CommentsLikesController::class, "store"])->name("comments.get");

