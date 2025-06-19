<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Todo::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title'=> 'required|string',
            'description' => 'nullable|string',
            'is_completed' => 'boolean|nullable',
            'due_date' => 'nullable|date'
        ]);

        $todo = $request->user()->todos()->create($data);

        return response()->json([
            'message' => 'Todo created successfully',
            'data' => $todo
        ], 201);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $todo = Todo::find($id);
        if(!$todo){
            return response()->json(['error'=> 'Todo not found']);
        }

        return response()->json(['Todo'=> $todo]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // update todo item
        $todo = Todo::findOrFail($id);

        if($request->user()->id !== $todo->user_id){
            return response()->json(['error'=> "Unauthorized"], 403);
        }

        $data = $request->validate([
            'title'=> 'required|string',
            'description' => 'nullable|string',
            'is_completed' => 'boolean|nullable',
            'due_date' => 'nullable|date'
        ]);

        $todo->update([
            'title' => $data['title'],
            'description' => $data['description'] ?? $todo->description,
            'is_completed' => $data['is_completed'] ?? $todo->is_completed,
            'due_date' => $data['due_date'] ?? $todo->due_date,
        ]);

        return response()->json([
            'message' => 'Todo updated successfully', 
            'data' => $todo
        ], 200);
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        //
        $todo = Todo::findOrFail($id);

        if(!$todo){
            return response()->json(['error'=> 'Todo not found!'], 404);
        }

        if($request->user()->id !== $todo->user_id){
            return response()->json(['error'=> "Unauthorized"], 403);
        }

        $todo->delete($id);

        return response()->json([
            'message' => 'Todo deleted successfully'
        ]);

    }
}
