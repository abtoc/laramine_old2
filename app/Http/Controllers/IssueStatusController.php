<?php

namespace App\Http\Controllers;

use App\Models\IssueStatus;
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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->merge([
            'is_closed' => $request->has('is_closed') ? 1 : 0,
        ]);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $issue_status = new IssueStatus();
        $issue_status->fill($request->all());
        $issue_status->save();

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
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, IssueStatus $issue_status)
    {
        $request->merge([
            'is_closed' => $request->has('is_closed') ? 1 : 0,
        ]);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $issue_status->fill($request->all());
        $issue_status->save();

        return to_route('issue_statuses.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\IssueStatus  $issue_status
     * @return \Illuminate\Http\Response
     */
    public function destroy(IssueStatus $issue_status)
    {
        $issue_status->delete();
        return to_route('issue_statuses.index');
    }

    /**
     * Move the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function move(Request $request)
    {
        $request->validate([
            'from' => ['required', 'integer', 'exists:issue_statuses,id'],
            'to' => ['required', 'integer', 'exists:issue_statuses,id'],
        ]);

        $issue_status_from = IssueStatus::findOrFail($request->post('from'));
        $issue_status_to = IssueStatus::findOrFail($request->post('to'));

        $issue_status_from->position = $issue_status_to->position;
        $issue_status_from->save();

        return to_route('issue_statuses.index');
    }
}
