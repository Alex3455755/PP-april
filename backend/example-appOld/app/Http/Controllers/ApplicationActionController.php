<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ApplicationActionController extends Controller
{
    // 📩 ОТКАЗ
    public function reject($id)
    {
        $application = Application::findOrFail($id);

        Mail::raw(
            "Здравствуйте, {$application->name}. К сожалению, вы получили отказ по вашей заявке.",
            function ($message) use ($application) {
                $message->to($application->email)
                        ->subject('Отказ по заявке');
            }
        );

        return response()->json([
            'success' => true,
            'message' => 'Письмо об отказе отправлено'
        ]);
    }

    // 🎉 ПРИГЛАШЕНИЕ + СОЗДАНИЕ ПОЛЬЗОВАТЕЛЯ
    public function invite($id)
    {
        $application = Application::findOrFail($id);

        // проверка: уже существует пользователь
        if (User::where('email', $application->email)->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Пользователь уже существует'
            ], 409);
        }

        // генерация пароля
        $password = Str::random(10);

        // создание пользователя
        $user = User::create([
            'login' => $application->name,
            'email' => $application->email,
            'password' => Hash::make($password),
        ]);

        // отправка письма
        Mail::raw(
            "Здравствуйте, {$application->name}! Вас пригласили. Ваш пароль: {$password}",
            function ($message) use ($application) {
                $message->to($application->email)
                        ->subject('Приглашение и доступ');
            }
        );

        return response()->json([
            'success' => true,
            'message' => 'Пользователь создан и письмо отправлено',
            'user' => $user
        ]);
    }
}