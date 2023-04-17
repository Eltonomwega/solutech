<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Status;
use Nette\Schema\ValidationException;


class StatusController extends ApiController
{

    private array $valid_rules= ['name'=>'required|string'];
    /**
     * Show all available statuses.
     */
    public function index(): JsonResponse
    {
        $statuses = Status::all();
        return $this->success_response($statuses,'Statuses fetched successfully!');
    }

    /**
     * Create a status.
     */
    public function create(Request $request): JsonResponse
    {
        try {
            $request->validate($this->valid_rules);
            $status = Status::create(['name'=>$request->get('name')]);

            return $this->success_response($status,'status created',201);
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
            $record = Status::findOrFail($id);

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
            Status::destroy([$id]);
            return $this->success_response(null,'Deleted');
        }catch (Exception $e){
            return $this->error_response($e->getMessage());
        }
    }
}
