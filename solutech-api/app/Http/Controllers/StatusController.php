<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Status;
use Nette\Schema\ValidationException;


class StatusController extends ApiController
{

    private array $status_rules= ['name'=>'required|string'];

    /**
     * @return JsonResponse
     */
    public function get_statuses(): JsonResponse
    {
        $statuses = get_all(new Status);
        return $this->success_response($statuses,'Statuses fetched successfully!');
    }

    /**
     * @param string $id
     * @return JsonResponse
     */
    public function get_status(string $id): JsonResponse
    {
        $status = get_one(new Status,$id)->first();
        return $this->success_response($status);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function create_status(Request $request): JsonResponse
    {
        try {
            $status = post_record(new Status,$request,$this->status_rules);
            return $this->success_response($status,'Created',201);
        } catch (Exception $e) {
            return $this->error_response($e->getMessage(),400);
        }
    }

    /**
     * @param Request $request
     * @param string $id
     * @return JsonResponse
     */
    public function update(Request $request, string $id): JsonResponse
    {
        try {
            $status = update_record(new Status,$request,$id,$this->status_rules);
            return $this->success_response($status,'Updated');

        }catch (Exception $e){
            return $this->error_response($e->getMessage(),400);
        }
    }

    /**
     * @param string $id
     * @return JsonResponse
     */
    public function destroy_status(string $id): JsonResponse
    {
        try {
            $status = delete_record(new Status,$id);
            return $this->success_response($status,'Deleted');
        }catch (Exception $e){
            return $this->error_response($e->getMessage());
        }
    }
}
