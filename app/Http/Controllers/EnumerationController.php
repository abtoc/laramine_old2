<?php

namespace App\Http\Controllers;

use App\Enums\EnumerationType as Type;
use App\Models\Enumeration;
use App\UseCases\Enumeration\DestroyAction;
use App\UseCases\Enumeration\MoveAction;
use App\UseCases\Enumeration\UpdateAction;
use Illuminate\Http\Request;

class EnumerationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $issue_priorities = Enumeration::withoutGlobalScope('enumeration')
                                    ->hasType(Type::ISSUE_PRIORITY)
                                    ->orderBy('position', 'asc')->get();
        return view('enumerations.index', compact('issue_priorities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('enumerations.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\UseCases\Enumeration\UpdateAction $action;
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, UpdateAction $action)
    {
        $request->merge([
            'active' => $request->has('active') ? 1 : 0,
            'is_default' => $request->has('is_default') ? 1 : 0,
        ]);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'active' => ['boolean'],
            'is_default' => ['boolean'],
        ]);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string'],
            'active' => ['boolean'],
            'is_default' => ['boolean']
        ]);

        $enumeration = new Enumeration();
        $action($enumeration, $request->all());

        return to_route('enumerations.index');
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
     * @param  \App\Models\Enumeration $enumeration
     * @return \Illuminate\Http\Response
     */
    public function edit(Enumeration $enumeration)
    {
        return view('enumerations.edit', compact('enumeration'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Enumeration $enumeration
     * @param  \App\UseCases\Enumeration\UpdateAction $action;
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Enumeration $enumeration, UpdateAction $action)
    {
        $request->merge([
            'active' => $request->has('active') ? 1 : 0,
            'is_default' => $request->has('is_default') ? 1 : 0,
        ]);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'active' => ['boolean'],
            'is_default' => ['boolean'],
        ]);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'active' => ['boolean'],
            'is_default' => ['boolean']
        ]);

        $action($enumeration, $request->all());

        return to_route('enumerations.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Enumeration $enumeration
     * @param  \App\UseCases\Enumeration\DestroyAction $action
     * @return \Illuminate\Http\Response
     */
    public function destroy(Enumeration $enumeration, DestroyAction $action)
    {
        $action($enumeration);
        return to_route('enumerations.index');
    }

    /**
     * Move the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\UseCases\Enumeration\MoveAction $action
     * @return \Illuminate\Http\Response
     */
    public function move(Request $request, MoveAction $action)
    {
        $request->validate([
            'from' => ['required', 'integer', 'exists:enumerations,id'],
            'to' => ['required', 'integer', 'exists:enumerations,id'],
        ]);

        $action($request->post('from'), $request->post('to'));

        return to_route('enumerations.index');
    }
}
