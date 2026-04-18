<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{



    public function index()
{
    $userId = Auth::id();
    $user = request()->user();

    if (!$user) {
        return response()->json(['error' => 'Unauthorized'], 401);
    }

   $chats = Chat::with(['author', 'interlocutor'])
    ->where(function ($q) use ($userId) {
        $q->where('author_id', $userId)
          ->orWhere('interlocutor_id', $userId);
    })
    ->orderBy('updated_at', 'desc')
    ->get();
    return response()->json($chats);
}
    // список чатов пользовател

    // создать чат
    public function store(Request $request)
    {
        $chat = Chat::create([
            'token' => uniqid('chat_'),
            'author_id' => $request->author_id,
            'interlocutor_id' => $request->interlocutor_id,
        ]);

        return response()->json($chat);
    }

    // показать чат
    public function show(Chat $chat)
    {
        return response()->json($chat);
    }

    public function destroy(Chat $chat)
    {
        $chat->delete();

        return response()->json(['message' => 'Chat deleted']);
    }
}