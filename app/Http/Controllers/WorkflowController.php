<?php

namespace App\Http\Controllers;

use App\UseCases\Workflow\EditAction;
use App\UseCases\Workflow\UpdateAction;
use Illuminate\Http\Request;

class WorkflowController extends Controller
{
    public function edit(Request $request, EditAction $action)
    {
        if($request->has('tracker_id')){
            list($workflows) = $action($request->query('tracker_id'));
            return view('workflows.edit', compact('workflows'));
        }
        return view('workflows.edit');
    }

    public function update(Request $request, UpdateAction $action)
    {
        $action($request->query('tracker_id'), $request->post());
        return to_route_query('workflows.edit');
    }
}
