<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\college;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class RequestController extends Controller
{
    // 📌 Получить все заявки
    public function index(): JsonResponse
    {
        try {
            $applications = Application::all();

            return response()->json([
                'success' => true,
                'data' => $applications
            ]);
        } catch (\Exception $e) {
            Log::error('Error in index: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Ошибка получения заявок'
            ], 500);
        }
    }

    // 📌 Создание заявки (у тебя уже было)
    public function store(Request $request): JsonResponse
{
    try {
        Log::info('Request data:', $request->all());

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'age' => 'required|integer|min:14|max:100',
            'experience' => 'required|integer|min:0|max:60',
            'education' => 'required|string|max:255',
            'college_id' => 'required|exists:colleges,id',
            'vacancie_id' => 'required|exists:vacancies,id',
        ]);

        $college = College::findOrFail($validated['college_id']);

        // 🔥 РЕЙТИНГ РАСЧЁТ
        $ageScore = (100 - $validated['age']) * 2;   // молодость важна
        $experienceScore = $validated['experience'] * 3; // опыт важнее
        $collegeScore = $college->rate ?? 0;

        $finalRate = $ageScore + $experienceScore + $collegeScore;

        $applicationData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'age' => $validated['age'],
            'experience' => $validated['experience'],
            'education' => $validated['education'],
            'rate' => $finalRate, // 👈 ВОТ ТВОЙ РЕЙТИНГ
            'college_id' => $validated['college_id'],
            'vacancie_id' => $validated['vacancie_id'],
        ];

        $application = Application::create($applicationData);

        return response()->json([
            'success' => true,
            'message' => 'Заявка успешно создана',
            'data' => $application
        ], 201);

    } catch (\Exception $e) {
        Log::error('Error in store: ' . $e->getMessage());

        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ], 500);
    }
}

    // 📌 Получить одну заявку
    public function show($id): JsonResponse
    {
        try {
            $application = Application::findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => $application
            ]);
        } catch (\Exception $e) {
            Log::error('Error in show: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Заявка не найдена'
            ], 404);
        }
    }

    // 📌 Обновить заявку
    public function update(Request $request, $id): JsonResponse
    {
        try {
            $application = Application::findOrFail($id);

            $validated = $request->validate([
                'name' => 'sometimes|string|max:255',
                'email' => 'sometimes|email|max:255',
                'age' => 'sometimes|integer|min:14|max:100',
                'experience' => 'sometimes|integer|min:0|max:60',
                'education' => 'sometimes|string|max:255',
                'rate' => 'nullable|numeric',
                'college_id' => 'sometimes|exists:colleges,id',
                'vacancie_id' => 'sometimes|exists:vacancies,id',
            ]);

            $application->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Заявка обновлена',
                'data' => $application
            ]);
        } catch (\Exception $e) {
            Log::error('Error in update: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Ошибка обновления'
            ], 500);
        }
    }

    // 📌 Удалить заявку
    public function destroy($id): JsonResponse
    {
        try {
            $application = Application::findOrFail($id);
            $application->delete();

            return response()->json([
                'success' => true,
                'message' => 'Заявка удалена'
            ]);
        } catch (\Exception $e) {
            Log::error('Error in destroy: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Ошибка удаления'
            ], 500);
        }
    }
}