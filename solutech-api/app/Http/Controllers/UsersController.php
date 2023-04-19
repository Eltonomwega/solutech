<?php

namespace App\Http\Controllers;

use App\Models\UserTasks;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UsersController extends ApiController
{
    private array $user_task_rules=[
        'user_id'=>'required|integer',
        'task_id'=>'required|integer',
        'due_date'=>'date',
        'start_time'=>'date',
        'end_time'=>'date',
        'remark'=>'string',
        'status_id'=>'required|integer'
    ];

    /**
     * @return JsonResponse
     */
    public function get_users_tasks():JsonResponse
    {
        $user_tasks = get_all(new UserTasks);
        return $this->success_response($user_tasks,'Fetched');
    }

    /**
     * @param string $id
     * @return JsonResponse
     */
    public function get_user_tasks(string $id):JsonResponse
    {
        $user_task = get_one(new UserTasks,$id);
        return $this->success_response($user_task,'Fetched');
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function create_user_task(Request $request):JsonResponse
    {
        try {
            $user_task = post_record(new UserTasks,$request,$this->user_task_rules);
            return $this->success_response($user_task,'Created',201);
        }catch (Exception $e){
            return $this->error_response($e->getMessage());
        }
    }

    /**
     * @param Request $request
     * @param string $id
     * @return JsonResponse
     */
    public function update_user_task(Request $request,string $id):JsonResponse
    {
        try {
            $user_task_record = update_record(new UserTasks,$request,$id,$this->user_task_rules);
            return $this->success_response($user_task_record,'Updated');
        }catch (Exception $e){
            return $this->error_response($e->getMessage(),400);
        }
    }

    /**
     * @param string $id
     * @return JsonResponse
     */
    public function destroy_user_task(string $id):JsonResponse
    {
        try {
            $user_task = delete_record(new UserTasks,$id);
            return $this->success_response($user_task,'Deleted');
        }catch (Exception $e){
            return $this->error_response($e->getMessage());
        }
    }

}
