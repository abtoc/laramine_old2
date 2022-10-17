<?php

namespace App\Http\Controllers;

use App\Enums\EnumerationType as Type;
use App\Models\Enumeration;
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
        $issue_priorities = Enumeration::hasType(Type::ISSUE_PRIORITY)->get();
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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->merge([
            'active' => $request->has('active') ? 1 : 0,
            'is_default' => $request->has('is_default') ? 1 : 0,
        ]);
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string'],
            'active' => ['boolean'],
            'is_default' => ['boolean']
        ]);

        $enumeration = new Enumeration();
        $enumeration->fill($request->all());
        $enumeration->save();

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
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Enumeration $enumeration)
    {
        $request->merge([
            'active' => $request->has('active') ? 1 : 0,
            'is_default' => $request->has('is_default') ? 1 : 0,
        ]);
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'active' => ['boolean'],
            'is_default' => ['boolean']
        ]);

        $enumeration->fill($request->all());
        $enumeration->save();

        return to_route('enumerations.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Enumeration $enumeration
     * @return \Illuminate\Http\Response
     */
    public function destroy(Enumeration $enumeration)
    {
        $enumeration->delete();
        return to_route('enumerations.index');
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
            'from' => ['required', 'integer', 'exists:enumerations,id'],
            'to' => ['required', 'integer', 'exists:enumerations,id'],
        ]);

        $enum_from = Enumeration::findOrFail($request->post('from'));
        $enum_to   = Enumeration::findOrFail($request->post('to'));

        $enum_from->position = $enum_to->position;
        $enum_from->save();

        return to_route('enumerations.index');
    }
}
