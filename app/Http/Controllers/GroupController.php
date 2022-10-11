<?php

namespace App\Http\Controllers;

use App\Enums\UserStatus;
use App\Enums\UserType;
use App\Models\Group;
use App\Rules\GroupNameRule;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    /**
     * Creation of controller instance
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(Group::class, 'group');
    }
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query= Group::active();
        $query = $query->when(!empty($request->query('name', '')), function($q) use($request){
                        return $q->where('name', 'like', '%'.$request->query('name').'%');
                    });
        $groups = $query->orderBy('name', 'asc')->paginate(config('laramine.per_page'));
        return view('groups.index', compact('groups'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('groups.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', new GroupNameRule()],
        ]);

        $group = new Group();
        $group->fill($request->all());
        $group->save();

        return to_route_query('groups.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function show(Group $group)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function edit(Group $group)
    {
        return view('groups.edit', compact('group'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Group $group)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', new GroupNameRule($group)],
        ]);

        $group->fill($request->all());
        $group->save();

        return to_route_query('groups.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Group $group)
    {
        $group->delete();
        return to_route_query('groups.index');
    }

    /**
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function users(Group $group)
    {
        $this->authorize('users', $group);

        return view('groups.users', compact('group'));
    }

    /**
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function projects(Group $group)
    {
        $this->authorize('projects', $group);

        return view('groups.projects', compact('group'));
    }
}
