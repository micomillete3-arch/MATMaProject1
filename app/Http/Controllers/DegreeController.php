<?php

namespace App\Http\Controllers;

use App\Models\Degree;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DegreeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $degrees = Degree::withCount('students')->orderBy('id')->get();

        if ($request->ajax() || $request->expectsJson()) {
            return view('partials.degrees_list', compact('degrees'));
        }

        return view('addDegree', compact('degrees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $degrees = Degree::withCount('students')->orderBy('id')->get();

        return view('addDegree', compact('degrees'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->merge([
            'name' => $request->input('name', $request->input('degree_name')),
        ]);

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:degrees,name',
        ]);

        $degree = Degree::create($validated);

        if ($request->ajax() || $request->expectsJson()) {
            return response()->json([
                'success' => true,
                'degree' => $degree,
                'redirect_url' => url('/degrees'),
            ]);
        }

        return redirect()->route('degrees.index')->with('success', 'Degree added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $degree = Degree::withCount('students')->findOrFail($id);

        return view('degreeDetails', compact('degree'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $degree = Degree::withCount('students')->findOrFail($id);

        return view('editDegree', compact('degree'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $degree = Degree::findOrFail($id);

        $request->merge([
            'name' => $request->input('name', $request->input('degree_name')),
        ]);

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('degrees', 'name')->ignore($degree->id),
            ],
        ]);

        $degree->update($validated);

        if ($request->ajax() || $request->expectsJson()) {
            return response()->json([
                'success' => true,
                'degree' => $degree,
                'redirect_url' => url('/degrees'),
            ]);
        }

        return redirect()->route('degrees.show', $degree->id)->with('success', 'Degree updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $degree = Degree::withCount('students')->findOrFail($id);

        if ($degree->students_count > 0) {
            if ($request->ajax() || $request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete a degree that is already assigned to students.',
                ], 422);
            }

            return redirect()
                ->route('degrees.index')
                ->with('error', 'Cannot delete a degree that is already assigned to students.');
        }

        $degree->delete();

        if ($request->ajax() || $request->expectsJson()) {
            return response()->json([
                'success' => true,
                'redirect_url' => url('/degrees'),
            ]);
        }

        return redirect()->route('degrees.index')->with('success', 'Degree deleted successfully.');
    }
}
