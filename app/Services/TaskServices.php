<?php

namespace App\Services;
use App\Enums\TaskStatusEnum;
use App\Models\Task;

class TaskServices
{

    public function indexService()
    {
        $user_id = auth()->user()->id;
        $tasks = Task::where('user_id', $user_id)->paginate(10);

        return [
            'data' => $tasks->items(),
            'currentPage' => $tasks->currentPage(),
            'previousPage' => $tasks->previousPageUrl(),
            'nextPage' => $tasks->nextPageUrl(),
        ];

    }

    public function createService($request)
    {
        $user_id = auth()->user()->id;
        $task = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'status' => TaskStatusEnum::from($request->status)->value,
            'user_id' => $user_id
        ]);

        return [
            'message' => 'Task created successfully',
            'task' => $task
        ];
    }

    public function showService($id)
    {
        $user_id = auth()->user()->id;
        $task_id = is_numeric($id);

        if (!$task_id) {
            return [
                'success' => false,
                'message' => 'The id must be an integer',
                
            ];
        } 
        $task = Task::where([
            ['id', '=', $id],
            ['user_id', '=', $user_id]
        ])->first();

        if (!$task) {
            return [
                'success' => false,
                'message' => "Task with id {$id} not found",
            ];
        }

        return [
            'success' => true,
            'task' => $task,
        ];
    }

    public function updateService($request ,$id){
        $user_id = auth()->user()->id;
        $task_id = is_numeric($id);

        if (!$task_id) {
            return [
                'success' => false,
                'message' => 'The id must be an integer',
            ];
        }

        $task = Task::where([
            ['id', '=', $id],
            ['user_id', '=', $user_id]
        ]);

        if (!$task->first()) {
            return [
                'success' => false,
                'message' => "Task with id {$id} not found",
            ];
        }

        $task->update([
            'title' => $request->title,
            'description' => $request->description,
            'status' => TaskStatusEnum::from($request->status)->value,
            'user_id' => $user_id
        ]);

        return [
            'success' => true,
            'message' => 'Task updated successfully',
        ];
    }

    public function destroyService($id){
        $user_id = auth()->user()->id;
        $task_id = is_numeric($id);

        if (!$task_id) {
            return [
                'success' => false,
                'message' => 'The id must be an integer',
            ];
        }
        $task = Task::where([
            ['id', '=', $id],
            ['user_id', '=', $user_id]
        ]);

        if (!$task->first()) {
            return [
                'success' => false,
                'message' => "Task with id {$id} not found",
            ];
        }

        $task->delete();

        return [
            'success' => true,
            'message' => 'Task deleted successfully',
        ];

    }

}