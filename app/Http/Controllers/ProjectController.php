<?php

namespace App\Http\Controllers;

use App\Enums\ProjectStatus;
use App\Models\Project;
use App\Rules\ProjectPublicChildrenRule;
use App\Rules\ProjectPublicParentRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Prologue\Alerts\Facades\Alert;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function admin(Request $request)
    {
        $this->authorize('viewAnyAdmin', Project::class);

        $query = Project::query();

        if($request->has('status')){
            if($request->query('status') != ProjectStatus::NONE){
                $query = $query->whereStatus($request->query('status', 1));
            }
        } else {
            $query = $query->whereStatus(ProjectStatus::ACTIVE);
        }
        if(!empty($request->query('name', ''))){
            $query = $query->where('name', 'like', '%'.$request->query('name').'%');
        }

        $projects = $query->withDepth()->get()->toFlatTree();
        return view('projects.admin', compact('projects'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = Project::whereIn('status',[ProjectStatus::ACTIVE, ProjectStatus::CLOSED]);
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

        if(!$project->isActive()){
            Alert::warning(__('This project has been closed and is read-only.'));
            Alert::flash();
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

    /**
     * Oepn the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project $project
     * @return \Illuminate\Http\Response
     */
    public function open(Request $request, Project $project)
    {
        $this->authorize('open', $project);

        if(!is_null($project->parent)){
            if($project->parent->status === ProjectStatus::ARCHIVE){
                Alert::danger(__('The parent project is the archive. Unarchive the parent project.'));
                Alert::flash();
                return redirect(url()->previous());
            }
            $project->status = $project->parent->status;
        } else {
            $project->status = ProjectStatus::ACTIVE;
        }
        $project->save();
        return redirect(url()->previous());
    }

    /**
     * Close the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project $project
     * @return \Illuminate\Http\Response
     */
    public function close(Request $request, Project $project)
    {
        $this->authorize('close', $project);

        foreach($project->children as $child){
            if($child->status === ProjectStatus::ACTIVE){
                Alert::danger(__('Sub project is active. Please close all sub projects.'));
                Alert::flash();
                return redirect(url()->previous());
            }
        }

        $project->status = ProjectStatus::CLOSED;
        $project->save();

        return redirect(url()->previous());
    }

    /**
     * Archive the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project $project
     * @return \Illuminate\Http\Response
     */
    public function archive(Request $request, Project $project)
    {
        $this->authorize('archive', $project);

        foreach($project->children as $child){
            if($child->status !== ProjectStatus::ARCHIVE){
                Alert::danger(__('Sub project is not archive. Please archive all sub projects.'));
                Alert::flash();
                return redirect(url()->previous());
            }
        }

        $project->status = ProjectStatus::ARCHIVE;
        $project->save();

        return redirect(url()->previous());
    }
}