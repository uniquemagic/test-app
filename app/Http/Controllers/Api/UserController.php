<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $user = User::findOrFail($id);
            return $user->toJson();
        } catch (Exception $e) {
            return response()->json($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function projects(Request $request, string $id)
    {
        try {

            $user     = User::findOrFail($id);
            $projects = $user->projects();

            if ($request->has('search')) {
                $search = $request->search;
                return $projects->where('name', 'like', '%' . $search . '%')->get()->toJson();
            }

            return $projects->get()->toJson();
        } catch (Exception $e) {
            return response()->json($e->getMessage());
        }
    }
}
