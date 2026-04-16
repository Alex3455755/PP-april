<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    // 📌 Получить все заявки
    public function index()
    {
        return response()->json(Application::all());
    }

    // 📌 Форма создания (обычно не используется в API)
    public function create()
    {
        return response()->json(['message' => 'Create form']);
    }

    // 📌 Создание заявки
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'age' => 'required|integer',
            'experience' => 'required|integer',
            'education' => 'required|string',
            'rate' => 'nullable|numeric',
            'college_id' => 'required|integer',
            'vacancie_id' => 'required|integer',
        ]);

        $application = Application::create($validated);

        return response()->json($application, 201);
    }

    // 📌 Получить одну заявку
    public function show(Application $application)
    {
        return response()->json($application);
    }

    // 📌 Форма редактирования
    public function edit(Application $application)
    {
        return response()->json($application);
    }

    // 📌 Обновление заявки
    public function update(Request $request, Application $application)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email',
            'age' => 'sometimes|integer',
            'experience' => 'sometimes|integer',
            'education' => 'sometimes|string',
            'rate' => 'nullable|numeric',
            'college_id' => 'sometimes|integer',
            'vacancie_id' => 'sometimes|integer',
        ]);

        $application->update($validated);

        return response()->json($application);
    }

    // 📌 Удаление заявки
    public function destroy(Application $application)
    {
        $application->delete();

        return response()->json(['message' => 'Deleted']);
    }
}