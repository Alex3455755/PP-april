<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\User;
use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use PHPMailer\PHPMailer\PHPMailer;

class ApplicationActionController extends Controller
{
    // 📩 ОТКАЗ
    public function reject($id)
    {
        $application = Application::findOrFail($id);

        $mail = new PHPMailer(true);

        try {
            $mail->SMTPDebug = 2;

            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'alexeigyll@gmail.com';
            $mail->Password = 'wjdd rplm hkhi ijhp';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;

            $mail->SMTPOptions = [
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true,
                ],
            ];

            $mail->setFrom('alexeigyll@gmail.com', 'staff manager');
            $mail->addAddress($application->email);

            $mail->isHTML(true);
            $mail->Subject = 'Отказ по заявке';
            $mail->Body = "Здравствуйте, {$application->name}. К сожалению, вы получили отказ по вашей заявке.";

            $mail->SMTPDebug = 2;
            $mail->Timeout = 10;
            $mail->Debugoutput = function($str, $level) {
                error_log("SMTP: $str");
            };

            if (!$mail->send()) {
                throw new \Exception($mail->ErrorInfo);
            }

            return response()->json([
                'success' => true,
                'message' => 'Письмо отправлено'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
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
        $password = Str::random(6);

        // создание пользователя
        $user = User::create([
            'login' => $application->name,
            'email' => $application->email,
            'password' => Hash::make($password),
        ]);

        $chat = Chat::create([
            'author_id' => 6,
            'interlocutor_id' => $user->id,
            'token' => Str::random(6)
        ]);

        $mail = new PHPMailer(true);

        try {
            $mail->SMTPDebug = 2;

            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'alexeigyll@gmail.com';
            $mail->Password = 'wjdd rplm hkhi ijhp';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;

            $mail->SMTPOptions = [
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true,
                ],
            ];

            $mail->setFrom('alexeigyll@gmail.com', 'staff manager');
            $mail->addAddress($application->email);

            $mail->isHTML(true);
            $mail->Subject = 'Приглашение и доступ';
            $mail->Body = "Здравствуйте, {$application->name}! Вас пригласили. Ваш пароль: {$password}";

            $mail->SMTPDebug = 2;
            $mail->Timeout = 10;
            $mail->Debugoutput = function($str, $level) {
                error_log("SMTP: $str");
            };

            if (!$mail->send()) {
                throw new \Exception($mail->ErrorInfo);
            }

            return response()->json([
                'success' => true,
                'message' => 'Письмо отправлено'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }

        return response()->json([
            'success' => true,
            'message' => 'Пользователь создан и письмо отправлено',
            'user' => $user
        ]);
    }
}