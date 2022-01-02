<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Friends extends Model
{
    use HasFactory;

    //Fillable fields
    protected $fillable = [
    	'user_id',
    	'friend_id',
    	'status'
    ];


    public function user ()
    {
    	return $this->belongsTo(User::class);
    }
}
