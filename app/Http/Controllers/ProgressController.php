<?php

namespace App\Http\Controllers;

use App\Models\Progress;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProgressRequest;
use App\Http\Requests\UpdateProgressRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\ProgressResource;
use App\Http\Resources\ProgressCollection;

class ProgressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new ProgressCollection(Progress::where('user_id', Auth::id())->get());
    }

    public function store(StoreProgressRequest $request)
    {
        $validated = $request->validated();

        $progress = Auth::user()->Progress()->create($validated);

        return new ProgressResource($progress);
    }

    public function show(Request $request, Progress $progress)
    {
        return new ProgressResource($progress);
    }

    public function update(UpdateProgressRequest $request, Progress $progress)
    {
        $validated = $request->validated();

        $progress->update($validated);

        return new ProgressResource($progress);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Progress $progress)
    {
        $progress->delete();
        return response()->noContent(204);
    }
}
