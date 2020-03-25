<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Message;

class ChatController extends Controller
{
    function message(Request $request){

        try{

            $message = new Message;
            $message->sender_id = $request->sender_id;
            $message->receiver_id = $request->receiver_id;
            $message->message = $request->message;
            $message->save();

            //$data = ['message' => $request->message, 'user' => $request->receiver_id];
		    //$redis->publish('message', json_encode($data));

            return response()->json(["success" => true]);

        }catch(\Exception $e){
            
            return response()->json(["success" => false, "error" => $e->getMessage(), "line" => $e->getLine()]);

        }

    }

    function getMessages(Request $request){

        $messages = Message::whereIn('sender_id', [$request->sender_id, $request->receiver_id])->whereIn('receiver_id', [$request->receiver_id, $request->sender_id])->take(20)->orderBy('id', 'asc')->get();

        //if(count($messages) <= 0){
            //$messages = Message::where('sender_id', $request->receiver_id)->where('receiver_id', $request->sender_id)->take(20)->orderBy('id', 'desc')->get();
        //}

        return response()->json($messages);

    }

}
