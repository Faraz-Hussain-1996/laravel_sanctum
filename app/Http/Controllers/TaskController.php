<?php

namespace App\Http\Controllers;

use App\Traits\HttpResponses;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    use HttpResponses;

    public function index()
    {
        return TaskResource::collection(
            Task::where('user_id',Auth::user()->id)->get()
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(StoreTaskRequest $request)
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        $request->validated($request->all());

        $task = Task::create([
            'user_id' => Auth::user()->id,
            'name' => $request->name,
            'description' => $request->description,
            'priority' => $request->priority,
        ]);

        return new TaskResource($task);
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        return $this->isNotAuthorize($task) ? $this->isNotAuthorize($task): new TaskResource($task);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        if(Auth::user()->id !== $task->user_id){
            return $this->error('','You are not authorize to make this request',403);
        }
        $task->update($request->all());
        return new TaskResource($task);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        return $this->isNotAuthorize($task) ? $this->isNotAuthorize($task): $task->delete();
    }

    private function isNotAuthorize($task){
        if(Auth::user()->id !== $task->user_id){
            return $this->error('','You are not authorize to make this request',403);
        }
    }
}
