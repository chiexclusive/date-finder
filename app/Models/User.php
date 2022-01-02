<?php

namespace App\Models;

use App\Models\Post;
use App\Models\Followers;
use App\Models\Friends;
use App\Models\Comments;
use App\Models\CommentsLikes;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'password',
        'dob',
        'gender', 
        'city',
        'country',
        'image',
        'cover_image'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * One to many user relationship to posts
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    /**
     * One to many relationship to likes
     */
    public function likes(){
        return $this->hasMany(Like::class);
    }

    /**
     * One to many relationship to followers
     */
    public function followers()
    {
        return $this->hasMany(Followers::class);
    }

    /**
     * One to many relationship to followers
     */
    public function friends()
    {
        return $this->hasMany(Friends::class);
    }


    /**
     * One to many relationship to followers
     */
    public function activities()
    {
        return $this->hasMany(Activities::class);
    }


    /**
    *   One to many relationship to comments
    */

    public function comments ()
    {
        return $this->hasMany(Comments::class);
    }


    /**
    *   One to many relationship to comments
    */

    public function commentLikes ()
    {
        return $this->hasMany(CommentsLikes::class);
    }


}
