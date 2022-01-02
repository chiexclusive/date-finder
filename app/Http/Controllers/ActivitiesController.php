<?php

namespace App\Http\Controllers;

use App\Models\Activities;
use Illuminate\Http\Request;

class ActivitiesController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($message)
    {
        if(auth()->user() !== null && isset($message)){
            auth()->user()->activities()->create([
                'activity' => $message
            ]);
        }
    }
}
