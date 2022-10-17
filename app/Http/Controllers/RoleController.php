<?php

namespace App\Http\Controllers;

use App\Enums\RoleBuiltin;
use App\Models\Role;
use App\UseCases\Role\DestroyAction;
use App\UseCases\Role\MoveAction;
use App\UseCases\Role\UpdateAction;
use Illuminate\Http\Request;

class RoleController extends Controller
{
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
     * @param  \App\UseCases\Role\UpdateAction $action
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, UpdateAction $action)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $role = new Role();
        $action($role, $request->all());

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
     * @param  \App\UseCases\Role\UpdateAction $action
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role, UpdateAction $action)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $action($role, $request->all());

        return to_route('roles.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Role  $role
     * @param  \App\UseCases\Role\DestroyAction $action
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role, DestroyAction $action)
    {
        $action($role);
        return to_route('roles.index');
    }

    /**
     * Move the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\UseCases\Role\MoveAction $action
     * @return \Illuminate\Http\Response
     */
    public function move(Request $request, MoveAction $action)
    {
        $request->validate([
            'from' => ['required', 'integer', 'exists:roles,id'],
            'to' => ['required', 'integer', 'exists:roles,id'],
        ]);

        $action($request->post('from'), $request->post('to'));

        return to_route('roles.index');
    }
}
