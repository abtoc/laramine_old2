<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Rules\ProjectPublicChildrenRule;
use App\Rules\ProjectPublicParentRule;
use App\Rules\ProjectPublicRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index_admin()
    {
        $this->authorize('viewAnyAdmin', Project::class);

        $projects = Project::withDepth()->get()->toFlatTree();
        return view('projects.admin', compact('projects'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = Project::query();
        if(!Auth::check()){
            $query = $query->whereIsPublic(true);
        }
        $projects = $query->withDepth()->get()->toTree();
        return view('projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Project::class);

        return view('projects.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Project::class);

        $request->merge([
            'is_public' => $request->has('is_public') ? 1 : 0,
            'inherit_members' => $request->has('inherit_members') ? 1 : 0,
        ]);
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'parent_id' => ['nullable', 'integer', 'exists:projects,id'],
            'is_public' => [new ProjectPublicParentRule($request->parent_id)],
            'inherit_members' => ['declined_if:parent_id,null'],
        ]);

        $project = new Project();
        $project->fill($request->all());
        $project->save();

        if($request->has('_previous')){
            return redirect($request->_previous);
        }

        return to_route('projects.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        if(!Auth::check() and !$project->is_public){
            abort(404);
        }
        return view('projects.show', ['project' => $project]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        $this->authorize('update', $project);
        return view('projects.edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        $this->authorize('update', $project);

        $request->merge([
            'is_public' => $request->has('is_public') ? 1 : 0,
            'inherit_members' => $request->has('inherit_members') ? 1 : 0,
        ]);
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'parent_id' => ['nullable', 'integer', 'exists:projects,id'],
            'is_public' => [
                    new ProjectPublicParentRule($request->parent_id),
                    new ProjectPublicChildrenRule($project),
                ],
            'inherit_members' => ['declined_if:parent_id,null'],
        ]);

        $project->fill($request->all());
        $project->save();

        return to_route('projects.edit', ['project' => $project]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $this->authorize('delete', $project);

        $project->delete();

        return to_route('projects.admin');
    }
}
