<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Task;
use Exception;
use Validator;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request_data = $request->all();

        $validator = Validator::make($request_data, Project::VALIDATOR_RULES, Project::VALIDATOR_MESSAGES);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        try {
            return Project::create($request_data)->toJson();
        } catch (Exception $e) {
            return response()->json($e->getMessage());
        }
    }

    public function storeTask(Request $request, string $id)
    {
        $request_data = $request->all();

        $validator = Validator::make($request_data, Project::VALIDATOR_RULES, Project::VALIDATOR_MESSAGES);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        try {
            $project = Project::findOrFail($id);
            $request_data['status'] = Task::getValidStatus($request);
            return $project->tasks()->create($request_data)->toJson();
        } catch (Exception $e) {
            return response()->json($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            return Project::findOrFail($id)->toJson();
        } catch (Exception $e) {
            return response()->json($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request_data = $request->all();

        $validator = Validator::make($request_data, Project::VALIDATOR_RULES, Project::VALIDATOR_MESSAGES);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        try {
            $project = Project::findOrFail($id);
            $project->update($request_data);
            return $project->toJson();
        } catch (Exception $e) {
            return response()->json($e->getMessage());
        }
    }

    public function updateTask(Request $request, string $id, string $task_id)
    {
        $request_data = $request->all();

        $request_data_with_task_id = array_merge($request_data, ['task_id' => $task_id]);
        $validation_rules = array_merge(Project::VALIDATOR_RULES, Task::VALIDATOR_RULES);

        $validator = Validator::make($request_data_with_task_id, $validation_rules, Project::VALIDATOR_MESSAGES);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        try {
            $project = Project::findOrFail($id);
            $request_data['status'] = Task::getValidStatus($request);
            $task = $project->tasks()->findOrFail($task_id);

            if (!$task->update($request_data)) {
                throw new Exception('task updating failed');
            }

            return $task->toJson();
        } catch (Exception $e) {
            return response()->json($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            Project::findOrFail($id)->delete();
            return response()->json(['success' => true]);
        } catch (Exception $e) {
            return response()->json($e->getMessage());
        }
    }

    public function destroyTask(string $id, string $task_id)
    {
        try {
            $project = Project::findOrFail($id);
            $task = $project->tasks()->findOrFail($task_id);
            if (!$task->delete()) {
                throw new Exception('task deleting failed');
            }
            return response()->json(['success' => true]);
        } catch (Exception $e) {
            return response()->json($e->getMessage());
        }
    }

    public function simpleTasksList(Request $request, string $id)
    {
        try {
            
            $project = Project::findOrFail($id);
            $tasks   = $project->tasks();

            if ($request->has('user_id')) {
                return $tasks->where('user_id', $request->user_id)->get()->toJson();
            }

            return $tasks->get()->toJson();

        } catch (Exception $e) {
            return response()->json($e->getMessage());
        }
    }
}
