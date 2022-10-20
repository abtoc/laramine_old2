<?php

namespace App\Http\Controllers;

use App\Models\Tracker;
use App\UseCases\Tracker\MoveAction;
use App\UseCases\Tracker\UpdateAction;
use App\UseCases\Tracker\DestroyAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TrackerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $trackers = Tracker::query()->get();
        return view('trackers.index', compact('trackers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('trackers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\UseCases\Tracker\UpdateAction $action
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, UpdateAction $action)
    {
        $action(new Tracker(), $request->all());
        return to_route('trackers.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tracker $tracker
     * @return \Illuminate\Http\Response
     */
    public function edit(Tracker $tracker)
    {
        $projects_old = DB::table('projects_trackers')
                            ->select('project_id')
                            ->whereTrackerId($tracker->id)
                            ->get()
                            ->pluck('project_id')
                            ->toArray();
        return view('trackers.edit', compact('tracker', 'projects_old'));        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tracker $tracker
     * @param  \App\UseCases\Tracker\UpdateAction $action
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tracker $tracker, UpdateAction $action)
    {
        $action($tracker, $request->all());
        return to_route('trackers.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tracker $tracker
     * @param  \App\UseCases\Tracker\DestoryAction $action
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tracker $tracker, DestroyAction $action)
    {
        $action($tracker);
        return to_route('trackers.index');
    }

    /**
     * Move the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\UseCases\Tracker\MoveAction $action
     * @return \Illuminate\Http\Response
     */
    public function move(Request $request, MoveAction $action)
    {
        $action($request->post('from'), $request->post('to'));
        return to_route('trackers.index');
    }
}
