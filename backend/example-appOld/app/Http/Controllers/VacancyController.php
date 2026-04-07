<?php

namespace App\Http\Controllers;

use App\Models\vacancy;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class VacancyController extends Controller
{
    /**
     * Display a listing of the resource.
     * GET /vacancies
     */
    public function index(): JsonResponse
    {
        $vacancies = vacancy::orderBy('created_at', 'desc')->get();
        
        return response()->json([
            'success' => true,
            'data' => $vacancies
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * GET /vacancies/create
     */
    public function create()
    {
        return response()->json([
            'fields' => [
                'title' => 'required|string|max:255',
                'description' => 'required|string|max:255',
                'salary' => 'required|string|max:255',
                'experience' => 'required|string',
                'skills' => 'required|string|max:255'
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * POST /vacancies
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'salary' => 'required|string|max:255',
            'experience' => 'required|string',
            'skills' => 'required|string|max:255',
        ]);

        $vacancy = vacancy::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Вакансия успешно создана',
            'data' => $vacancy
        ], 201);
    }

    /**
     * Display the specified resource.
     * GET /vacancies/{id}
     */
    public function show(vacancy $vacancy): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $vacancy
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     * GET /vacancies/{id}/edit
     */
    public function edit(vacancy $vacancy): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $vacancy
        ]);
    }

    /**
     * Update the specified resource in storage.
     * PUT/PATCH /vacancies/{id}
     */
    public function update(Request $request, vacancy $vacancy): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string|max:255',
            'salary' => 'sometimes|string|max:255',
            'experience' => 'sometimes|string',
            'skills' => 'sometimes|string|max:255',
        ]);

        $vacancy->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Вакансия успешно обновлена',
            'data' => $vacancy
        ]);
    }

    /**
     * Remove the specified resource from storage.
     * DELETE /vacancies/{id}
     */
    public function destroy(vacancy $vacancy): JsonResponse
    {
        $vacancy->delete();

        return response()->json([
            'success' => true,
            'message' => 'Вакансия успешно удалена'
        ]);
    }
}