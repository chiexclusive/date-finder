<?php

namespace App\Models;

use App\Models\Like;
use App\Models\User;
use App\Models\Comments;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'message',
        'card',
        'image',
        'video', 
        'visibility',
        'video_public_id',
        'image_public_id'
    ];

    //Many to one relationship to users
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * One to many relationship to likes
     */
    public function like(){
        return $this->belongsTo(Like::class);
    }

    /**
     * One to many relationship to likes
     */
    public function likes(){
        return $this->hasMany(Like::class);
    }


    /**
     * One to many relationship to likes
     */
    public function comments(){
        return $this->hasMany(Comments::class);
    }

    
}
