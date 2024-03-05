<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $tasks = Task::class;
        if ($request->has('status')) {
            $tasks->orwhere('is_read', $request->input('status'));
        }
        if ($request->has('date')){
            $tasks->orwhere('created_at', $request->input('date'));
        }

        $tasks->get();

        return response()->json($tasks);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $task = new Task();

        $task->name = $request->name;
        $task->description = $request->description;
        $task->created_user = auth('sanctum')->user()->id;
        $task->responsible_user = $request->responsible_user_id;

        $task->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $task = Task::find($id);

        $task->is_read = 1;
        $task->save();

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
        $task = Task::find($id);

        $task->name = $request->name;
        $task->description = $request->description;
        $task->created_user = auth('sanctum')->user()->id;
        $task->responsible_user = $request->responsible_user_id;
        $task->save();

        return response()->json($task);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Task::destroy($id);

        return response()->json(['message' => 'Deleted']);
    }
}
