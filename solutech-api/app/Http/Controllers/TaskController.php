<?php

namespace App\Http\Controllers;

use App\Models\Status;
use App\Models\Tasks;
use App\Models\User;
use App\Models\UserTasks;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TaskController extends ApiController
{
    private array $task_rules= [
        'name'=>'required|string',
        'description'=>'string|nullable',
        'due_date'=>'date|nullable',
        'status_id'=>'integer'
    ];

    /**
     * @return JsonResponse
     */
    public function get_tasks(): JsonResponse
    {
        $tasks = get_all(new Tasks);
        return $this->success_response($tasks,'Fetched');
    }

    public function get_task(string $id):JsonResponse
    {
        try {
            $task = get_one(new Tasks,$id)->first();
            return $this->success_response($task,'Fetched');

        }catch (Exception $e){
            return $this->error_response($e->getMessage());
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function create_task(Request $request): JsonResponse
    {
        try {
            $task= post_record(new Tasks,$request,$this->task_rules);
            return $this->success_response($task,'Created',201);
        } catch (Exception $e) {
            return $this->error_response($e->getMessage(),400);
        }
    }

    /**
     * @param Request $request
     * @param string $id
     * @return JsonResponse
     */
    public function update_task(Request $request, string $id): JsonResponse
    {
        try {
            $task_record = update_record(new Tasks,$request,$id,$this->task_rules);
            return $this->success_response($task_record,'Updated');

        }catch (Exception $e){
            return $this->error_response($e->getMessage(),400);
        }
    }

    /**
     * @param string $id
     * @return JsonResponse
     */
    public function destroy_task(string $id): JsonResponse
    {
        try {
            $task = delete_record(new Tasks,$id);
            return $this->success_response($task,'Deleted');
        }catch (Exception $e){
            return $this->error_response($e->getMessage());
        }
    }
}
