<?php

namespace App\Http\Controllers;

use App\Models\IssueStatus;
use App\UseCases\IssueStatus\DestroyAction;
use App\UseCases\IssueStatus\MoveAction;
use App\UseCases\IssueStatus\UpdateAction;
use Illuminate\Http\Request;

class IssueStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $issue_statuses = IssueStatus::all();
        return view('issue_statuses.index', compact('issue_statuses'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index_project()
    {
        $issue_statuses = IssueStatus::all();
        return view('issue_statuses.index', compact('issue_statuses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('issue_statuses.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\UseCases\IssueStatus\UpdateAction $action;
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, UpdateAction $action)
    {
        $request->merge([
            'is_closed' => $request->has('is_closed') ? 1 : 0,
        ]);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'is_closed' => ['boolean'],
        ]);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $issue_status = new IssueStatus();
        $action($issue_status, $request->all());

        return to_route('issue_statuses.index');
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
     * @param  \App\Models\IssueStatus  $issue_status
     * @return \Illuminate\Http\Response
     */
    public function edit($issue_status)
    {
        return view('issue_statuses.edit', compact('issue_status'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\IssueStatus  $issue_status
     * @param  \App\UseCases\IssueStatus\UpdateAction $action;
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, IssueStatus $issue_status, UpdateAction $action)
    {
        $request->merge([
            'is_closed' => $request->has('is_closed') ? 1 : 0,
        ]);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'is_closed' => ['boolean'],
        ]);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);


        $action($issue_status, $request->all());

        return to_route('issue_statuses.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\IssueStatus  $issue_status
     * @param  \App\UseCases\IssueStatus\UpdateAction $action;
     * @return \Illuminate\Http\Response
     */
    public function destroy(IssueStatus $issue_status, DestroyAction $action)
    {
        $action($issue_status);
        return to_route('issue_statuses.index');
    }

    /**
     * Move the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\UseCases\IssueStatus\UpdateAction $action;
     * @return \Illuminate\Http\Response
     */
    public function move(Request $request, MoveAction $action)
    {
        $request->validate([
            'from' => ['required', 'integer', 'exists:issue_statuses,id'],
            'to' => ['required', 'integer', 'exists:issue_statuses,id'],
        ]);

        $action($request->post('from'), $request->post('to'));

        return to_route('issue_statuses.index');
    }
}
