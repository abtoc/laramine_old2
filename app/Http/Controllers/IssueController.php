<?php

namespace App\Http\Controllers;

use App\Models\Issue;
use App\Models\Project;
use App\UseCases\Issue\StoreAction;
use Illuminate\Http\Request;

class IssueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Issue::class);

        if(!request()->has('f')){
            $request->merge([
                'f' => [
                    'status',
                ],
            ]);
        }

        if(!$request->has('q')){
            $request->merge([
                'q' => [
                    'project',
                    'tracker',
                    'status',
                    'priority',
                    'subject',
                    'assigned_to',
                    'updated_at',
                ],
            ]);
        }

        $query = Issue::query();
        $issues = $query->sortable(['id', 'desc'])->paginate(config('laramine.per_page'));
        return view('issues.index', compact('issues'));
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project $project
     * @return \Illuminate\Http\Response
     */
    public function index_project(Request $request, Project $project)
    {
        $this->authorize('viewAny', Issue::class);

        if(!$request->has('q')){
            $request->merge([
                'q' => [
                    'tracker',
                    'status',
                    'priority',
                    'subject',
                    'assigned_to',
                    'updated_at',
                ],
            ]);
        }
        $query = Issue::query();
        $issues = $query->sortable(['id', 'desc'])->paginate(config('laramine.per_page'));
        return view('issues.index-project', compact('project', 'issues'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Issue::class);
        return view('issues.create');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Models\Project $project
     * @return \Illuminate\Http\Response
     */
    public function create_project(Project $project)
    {
        $this->authorize('create', Issue::class);
        return view('issues.create-project', compact('project'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\UseCases\Issue\StoreAction $action
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, StoreAction $action)
    {
        $this->authorize('create', Issue::class);

        $request->validate([
            'project_id' => ['required', 'integer', 'exists:projects,id'],
            'tracker_id' => ['required', 'integer', 'exists:trackers,id'],
            'subject' => ['required',  'string', 'max:255'],
            'status_id' => ['required', 'integer', 'exists:issue_statuses,id'],
            'priority_id' => ['required', 'integer', 'exists:enumerations,id'],
            'assigned_to_id' => ['nullable', 'integer', 'exists:users,id'],
            'parent_id' => ['nullable', 'integer', 'exists:issues,id'],
            'start_date' => ['nullable', 'date'],
            'due_date' => ['nullable', 'date'],
            'done_raito' => ['nullable', 'integer','between:0,100'],
        ]);

        $action($request->all());
        return to_route('issues.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\UseCases\Issue\StoreAction $action
     * @return \Illuminate\Http\Response
     */
    public function store_project(Request $request, StoreAction $action)
    {
        $this->authorize('create', Issue::class);
        $action($request->all());
        return to_route('issues.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Issue $issue
     * @return \Illuminate\Http\Response
     */
    public function show(Issue $issue)
    {
        $this->authorize('view', $issue);
        return view('issues.show', compact($issue));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Issue $issue
     * @return \Illuminate\Http\Response
     */
    public function edit(Issue $issue)
    {
        $this->authorize('update', $issue);
        return view('issues.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Issue $issue
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Issue $issue)
    {
        $this->authorize('update', $issue);
        return to_route('issues.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Issue $issue
     * @return \Illuminate\Http\Response
     */
    public function destroy(Issue $issue)
    {
        $this->authorize('destroy', $issue);
        return to_route('issues.index');
    }
}
