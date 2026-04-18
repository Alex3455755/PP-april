<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    // сообщения чата
    public function index($chatId)
{

    
    return Message::with('user')
        ->where('chat_id', $chatId)
        ->orderBy('created_at')
        ->get();
}

    // отправка сообщения
    public function store(Request $request)
    {

        $userId = Auth::id();
        $data = $request->validate([
            'chat_id' => 'required|exists:chats,id',
            'text' => 'nullable|string',
            'file' => 'nullable|file|max:10240',
        ]);

        $filePath = null;

        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('messages', 'public');
        }

        $message = Message::create([
            'chat_id' => $data['chat_id'],
            'text' => $data['text'],
            'filePath' => $filePath,
            'user_id' => $userId,
        ]);

        // обновляем чат (чтобы сортировка работала)
        Chat::where('id', $data['chat_id'])->update([
            'updated_at' => now()
        ]);

        return response()->json($message);
    }

    public function show(Message $message)
    {
        return response()->json($message);
    }

    public function destroy(Message $message)
    {
        $message->delete();

        return response()->json(['message' => 'deleted']);
    }
}