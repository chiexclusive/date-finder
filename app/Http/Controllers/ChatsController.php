<?php

namespace App\Http\Controllers;

use App\Models\Friends;
use App\Models\Followers;
use App\Models\Chats;

use Illuminate\Http\Request;

class ChatsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Chats::where("first_user_id", "=", auth()->user()->id)->orWhere("second_user_id", "=", auth()->user()->id)->orderBy("updated_at", "desc")->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        //Validate the request
        if($request->message == "") return;

        if($request->route('receipient') == null || $request->route('receipient') == auth()->user()->id) return;

        if($request->route('id') == null) return;

        $id = $request->route("id");
        $receipient = $request->route("receipient");

        $message = $request->message;
        $time = date("Y-m-d h:i:s A");
        $newMessage = [
            "sender" =>  auth()->user()->id,
            "receiver" =>  $receipient,
            "message" =>  $message,
            "read" =>  false,
            "time" =>  $time
        ];

        $chat = Chats::where("id", "=", $id)
                ->where([["first_user_id", "=", auth()->user()->id], ["second_user_id", "=", $receipient]])
                ->orWhere([["second_user_id", "=", auth()->user()->id], ["first_user_id", "=", $receipient]]);


        //Create new chat if the chat exist already
        if($chat->count() == 0) {

            Chats::create([
                "first_user_id" =>  auth()->user()->id,
                "second_user_id" => $receipient,
                "messages" =>  json_encode([0 => $newMessage])
            ]);
            return json_encode(["success" => true]);
        }


        //Register chat
        $messages = $chat->get()[0]['messages'] == "" ? [] : json_decode($chat->get()[0]['messages']);

        array_push($messages, $newMessage);

        $messages = json_encode($messages);
        $chat->update(["messages" => $messages]);
        return json_encode(["success" => true]);
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
    public function update(Request $request)
    {
        $chatId = $request->route('chatId');
        $msgId = $request->route('msgId');

        if($chatId == null)  return json_encode(["success" => false]);

        if($msgId == null)  return json_encode(["success" => false]);

        $chat = Chats::where("id", "=", $chatId);

        if($chat->count() == 0) return json_encode(["success" => false]);

        $messages = json_decode($chat->get()[0]['messages']);

        //Update the message to read;
        $messages[$msgId]->read = true;

        $messages = json_encode($messages);

        $chat->update(["messages" => $messages]);

        return json_encode(["success" => true]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
