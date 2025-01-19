<?php

namespace App\Http\Controllers;

use App\Enums\TaskStatusEnum;
use App\Http\Requests\RequestTaskCreate;
use App\Http\Requests\RequestTaskUpdate;
use App\Models\Task;
use App\Services\TaskServices;
use League\CommonMark\Parser\Block\BlockContinueParserWithInlinesInterface;
use Throwable;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{

    protected $taskService;

    public function __construct(TaskServices $taskService)
    {
        $this->taskService = $taskService;
    }

    public function index()
    {
        try {

            $tasks = $this->taskService->indexService();
            return response()->json($tasks, 200);

        } catch (Throwable $th) {
            return response()->json($th->getMessage(), 401);
        }
    }

    public function create(RequestTaskCreate $request)
    {
        try {

            $tasks = $this->taskService->createService($request);
            return response()->json($tasks,201);

        } catch (Throwable $th) {
            return response()->json($th->getMessage(), 401);
        }

    }


    public function show($id)
    {
        try {
            $task = $this->taskService->showService($id);

            if (!$task['success']) {
                return response()->json(['message'=>$task['message']], 400);
            }
            return response()->json($task['task'], 200);


        } catch (Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }


    public function update(RequestTaskUpdate $request, $id)
    {
        try {
            $task = $this->taskService->updateService($request, $id);

            if (!$task['success']) {
                return response()->json(['message'=>$task['message']], 400);
            }
            return response()->json(['message'=>$task['message']], 200);

        } catch (Throwable $th) {
            return response()->json($th->getMessage(), 401);
        }

    }


    public function destroy($id)
    {
        try {

            $task = $this->taskService->destroyService($id);
            if (!$task['success']) {
                return response()->json(['message'=>$task['message']], 400);
            }
            return response()->json(['message'=>$task['message']], 200);

        } catch (Throwable $th) {
            return response()->json($th->getMessage(), 401);
        }
    }

    public function notFound()
    {
        return response()->json(['message' => 'Resource not found'], 404);
    }
}
