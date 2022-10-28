<?php

namespace App\Http\Controllers;

use App\Events\Message;
use App\Models\Message as ModelsMessage;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function message(Request $request)
    {

        $request->validate([
            'message' => ['required'],

        ]);


        // event(new Message($request->input('username'), $request->input('message')));
        event(new Message( $request->message));

        $newMessage = new ModelsMessage();

        if($newMessage->user_id != 1){

            $newMessage->user_id = 1;
            $newMessage->message =  $request->message;
            $newMessage->status = 'pending';

        }



        if($newMessage->user_id == 1){
            $newMessage->message =  $request->message;
            $newMessage->status = 'responded';

        }

        $newMessage->save();

        return response()->json([
            'success' => true,
            'msg' => 'Message sent'
        ]);
    }
}
