<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\ColumnsRequest;
use App\Http\Requests\V1\TasksRequest;
use App\Http\Resources\V1\ColumnsResource;
use App\Http\Resources\V1\TasksResource;
use App\Models\V1\Task;

class TasksController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(TasksRequest $request)
    {
        $request = $request->validated();

        $tasks = new Task();
        $tasks->description = $request['description'];
        $tasks->column_id = $request['column_id'];
        $tasks->save();

        return new TasksResource($tasks);
    }


    public function show($id)
    {
        $column = Task::find($id);

        if (is_null($column)) {
            return response()->json(['message' => 'Task not found.'], 404);
        }

        return new TasksResource($column);
    }


    /**
     * @param ColumnsRequest $request
     * @param $id
     * @return ColumnsResource|\Illuminate\Http\JsonResponse
     */
    public function update(TasksRequest $request, $id)
    {
        $validatedReq = $request->validated();

        $task = Task::find($id);
        if (is_null($task)) {
            return response()->json(['message' => 'Task not found.'], 404);
        }

        $task->description = $validatedReq['description'];
        $task->column_id = $validatedReq['column_id'];
        $task->save();

        return new TasksResource($task);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id)
    {
        $task = Task::find($id);
        if(is_null($task)) {
            return response()->json(['message' => 'Task not found.'], 404);
        }
        $task->delete();

        return response()->json(['message' => 'Delete successful.']);;
    }
}
