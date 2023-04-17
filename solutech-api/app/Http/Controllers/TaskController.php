<?php

namespace App\Http\Controllers;

use App\Models\Status;
use App\Models\Tasks;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TaskController extends ApiController
{
    private array $valid_rules= [
        'name'=>'required|string',
        'description'=>'string',
        'due_date'=>'date',
        'status_id'=>'integer'
    ];
    /**
     * Show all available tasks.
     */
    public function index(): JsonResponse
    {
        $tasks = Tasks::where('deleted_at','=',null)->get();
        return $this->success_response($tasks,'Tasks fetched successfully!');
    }

    /**
     * Create a task.
     */
    public function create(Request $request): JsonResponse
    {
        try {
            $request->validate($this->valid_rules);
            $status = Tasks::create($request->all());

            return $this->success_response($status,'Created',201);
        } catch (Exception $e) {
            return $this->error_response($e->getMessage(),400);
        }
    }

    /**
     * Update the specified status.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        try {
            $record = Tasks::findOrFail($id);

            foreach ($request->all() as $field => $value){
                if (array_key_exists($field,$this->valid_rules)){
                    $request->validate([$field=>$this->valid_rules[$field]]);
                    $record->$field = $value;
                }
            }
            $record->save();
            return $this->success_response($record,'Updated');

        }catch (Exception $e){
            return $this->error_response($e->getMessage(),400);
        }
    }

    /**
     * Remove the specified status from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            //soft delete
            $record = Tasks::findOrFail($id);
            $record->deleted_at = Carbon::now();
            $record->save();
            return $this->success_response($record,'Deleted');
        }catch (Exception $e){
            return $this->error_response($e->getMessage());
        }
    }
}
