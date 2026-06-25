<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function store(Request $request)
    {
        $message = Message::create([
            'sender_id'   => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'content'     => $request->content,
        ]);

        broadcast(new \App\Events\MessageSent($message))->toOthers();

        return response()->json($message);
    }

    public function index(Request $request)
    {
        $userId = $request->query('user'); // ← query() évite le conflit avec $request->user()

        // Récupère TOUS les messages impliquant l'utilisateur connecté
        $messages = Message::with('sender')
            ->where(function ($q) {
                $q->where('sender_id', Auth::id())
                  ->orWhere('receiver_id', Auth::id());
            })
            ->latest()
            ->get();

        $users = User::where('id', '!=', Auth::id())->get(); // exclut soi-même

        return view('chat.index', compact('messages', 'users'));
    }
}