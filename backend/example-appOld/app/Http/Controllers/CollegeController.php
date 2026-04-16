<?php

namespace App\Http\Controllers;

use App\Models\College;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CollegeController extends Controller
{
    /**
     * Display a listing of the resource.
     * GET /api/colleges
     */
    public function index(): JsonResponse
    {
        $colleges = College::orderBy('name')->get();
        
        return response()->json([
            'success' => true,
            'data' => $colleges,
            'count' => $colleges->count()
        ]);
    }

    /**
     * Get only universities (ВУЗы)
     * GET /api/colleges/universities
     */
    public function getUniversities(): JsonResponse
    {
        $universities = College::universities()->orderBy('rate')->get();
        
        return response()->json([
            'success' => true,
            'data' => $universities,
            'count' => $universities->count()
        ]);
    }

    /**
     * Get only colleges (СПО)
     * GET /api/colleges/colleges-only
     */
    public function getCollegesOnly(): JsonResponse
    {
        $colleges = College::colleges()->orderBy('name')->get();
        
        return response()->json([
            'success' => true,
            'data' => $colleges,
            'count' => $colleges->count()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * POST /api/colleges
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:colleges,name',
            'rate' => 'nullable|integer',
            'type' => 'required|in:ВУЗ,СПО'
        ]);

        $college = College::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Учебное заведение успешно создано',
            'data' => $college
        ], 201);
    }

    /**
     * Display the specified resource.
     * GET /api/colleges/{id}
     */
    public function show(College $college): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $college
        ]);
    }

    /**
     * Update the specified resource in storage.
     * PUT/PATCH /api/colleges/{id}
     */
    public function update(Request $request, College $college): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255|unique:colleges,name,' . $college->id,
            'rate' => 'nullable|integer',
            'type' => 'sometimes|in:ВУЗ,СПО'
        ]);

        $college->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Учебное заведение успешно обновлено',
            'data' => $college
        ]);
    }

    /**
     * Remove the specified resource from storage.
     * DELETE /api/colleges/{id}
     */
    public function destroy(College $college): JsonResponse
    {
        $college->delete();

        return response()->json([
            'success' => true,
            'message' => 'Учебное заведение успешно удалено'
        ]);
    }

    /**
     * Search colleges by name
     * GET /api/colleges/search?q=пермский
     */
    public function search(Request $request): JsonResponse
    {
        $query = $request->get('q');
        
        if (!$query) {
            return $this->index();
        }
        
        $colleges = College::where('name', 'like', "%{$query}%")
            ->orderBy('name')
            ->get();
        
        return response()->json([
            'success' => true,
            'data' => $colleges,
            'count' => $colleges->count()
        ]);
    }
}