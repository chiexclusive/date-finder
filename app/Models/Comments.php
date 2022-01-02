<?php

namespace App\Models;

use \App\Models\User;
use \App\Models\CommentsLikes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    use HasFactory;

    protected $fillable = [
    	"post_id",
    	"comment"
    ];


    public function user()
    {
    	return $this->belongsTo(User::class);
    }


    public function likes()
    {
    	return $this->hasMany(CommentsLikes::class);
    }
}
