<?php

namespace App\Http\Controllers;

use App\Enums\Permissions;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
     /**
     * Creation of controller instance
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(Role::class, 'role');
    }
   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::all();
        return view('roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('roles.create');
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
            'name' => ['required', 'string', 'max:255'],
        ]);

        $role = new Role();
        $role->fill($request->all());

        $role->save();

        return to_route('roles.index');
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
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        return view('roles.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $role->fill($request->all());
        $role->save();

        return to_route('roles.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $role->delete();
        return to_route('roles.index');
    }

    /**
     * Move the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function move(Request $request)
    {
        $this->authorize('move', Role::class);

        $request->validate([
            'from' => ['required', 'integer', 'exists:roles,id'],
            'to' => ['required', 'integer', 'exists:roles,id'],
        ]);

        $role_from = Role::findOrFail($request->post('from'));
        if($role_from->builtin !== 0){
            abort(404);
        }
        $role_to = Role::findOrFail($request->post('to'));
        if($role_to->builtin !== 0){
            abort(404);
        }

        $role_from->position = $role_to->position;
        $role_from->save();

        return to_route('roles.index');
    }
}
