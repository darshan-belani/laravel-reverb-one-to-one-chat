<?php

namespace App\Http\Controllers;

use App\Events\SendMessage;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getMessage(Request $request)
    {
        $receiverData = User::where('id', '!=', auth()->user()->id)->first();
        $page = $request->input('page', 1);
        $messages =[];
        if ($receiverData) {
            $receiverId = $receiverData->id;
            $userId = auth()->user()->id;
            $messages = Chat::with('sender')
                ->with('receiver')->where(function ($query) use ($receiverId, $userId) {
                    $query->where('sender_id', $receiverId)
                        ->where('receiver_id', $userId);
                })->orWhere(function ($query) use ($receiverId, $userId) {
                    $query->where('sender_id', $userId)
                        ->where('receiver_id', $receiverId);
                })->orderBy('created_at', 'desc')->paginate(10, ['*'], 'page', $page);
            $messages->getCollection()->transform(function ($message) use ($userId) {
                $message->sender_type = $userId == $message->sender_id ? 'self' : 'other';
                return $message;
            });
        }
        return response()->json([
            "status"=>200,
            "data"=>$messages,
            "totalPages"=> count($messages) > 0 ? $messages->lastPage() : 0,
        ]);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        if ($request->receiver_id == null) {
            $receiverData = User::where('id', '!=', auth()->user()->id)->first();
        }
        $addMessage = new Chat();
        $addMessage->sender_id = $request->sender_id;
        $addMessage->receiver_id = $receiverData->id;
        $addMessage->message = $request->message;
        if ($addMessage->save()) {
            $addMessage->createdAt = $addMessage->created_at;
            event(new SendMessage($addMessage));
            return response()->json([
                "status" => 200,
                "data" => $addMessage,
                "message" => "message Save",
            ]);
        }
    }
}
