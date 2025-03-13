<?php

namespace App\Http\Controllers\Api\V1\Task;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Task::with('user')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'user_id' => 'required|exists:users,id',
                'start_time' => 'nullable|date',
            ]);

            $task = Task::create($validated);
            return response()->json($task, 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation Error',
                'errors' => $e->validator->errors(),
            ], 422);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $task = Task::with('user')->findOrFail($id);
        return response()->json($task);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try{
            $task = Task::findOrFail($id);

            $validated = $request->validate([
                'title' => 'sometimes|required|string|max:255',
                'description' => 'sometimes|nullable|string',
                'status' => 'sometimes|required|in:pending,in_progress,completed',
                'start_time' => 'sometimes|nullable|date',
            ]);
    
            $task->update($validated);
    
            return response()->json($task);
        }catch(ValidationException $e) {
            return response()->json([
                'message' => 'Validation Error',
                'errors' => $e->validator->errors(),
            ], 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Task::findOrFail($id)->delete();
        return response()->json(['message' => 'Task deleted']);
    }

        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getKanbanData()
    {
        return response()->json([
            "pending" => Task::where('status', 'pending')->get(),
            "in_progress" => Task::where('status', 'in_progress')->get(),
            "completed" => Task::where('status', 'completed')->get()
        ]);
    }
}
