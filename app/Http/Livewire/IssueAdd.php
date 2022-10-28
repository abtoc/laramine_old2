<?php

namespace App\Http\Livewire;

use App\Enums\EnumerationType as Type;
use App\Models\Enumeration;
use App\Models\IssueStatus;
use App\Models\Project;
use App\Models\Tracker;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class IssueAdd extends Component
{
    public $projects = [];
    public $project_id;
    public $trackers = [];
    public $tracker_id;
    public $fields_bits = 0;
    public $subject;
    public $description;
    public $statuses = [];
    public $status_id;
    public $assigned_to_id;
    public $parent_id;
    public $start_date;
    public $due_date;
    public $done_raito;
    public $priority_id;
    public $priorites = [];
    public $assignments = [];
    public $watchers = [];

    protected $listeners = [
        'refresh' => '$refresh',
    ];

    public function mount($project)
    {
        $ids = DB::table('projects_trackers')->select('project_id')->groupBy('project_id')->get()->pluck('project_id')->toArray();

        $query = Project::withoutGlobalScope('project')
            ->select(['children.id','children.name', DB::raw('count(parents.id)-1 as depth')])
            ->fromRaw('projects as parents, projects as children')
            ->whereRaw('children._lft between parents._lft and parents._rgt')
            ->whereIn('parents.id', $ids)
            ->whereIn('children.id', $ids)
            ->when(!is_null($project),function($q) use($project){
                $q->where('parents._lft', '>=', $project->root->_lft)
                  ->where('parents._rgt', '<=', $project->root->_rgt)
                  ->where('children._lft', '>=', $project->root->_lft)
                  ->where('children._rgt', '<=', $project->root->_rgt);
            })
            ->groupBy('children.id', 'children.name')
            ->orderBy('children._lft', 'asc');

        $this->projects = $query->get()->toArray();
        $this->project_id = old('project_id', $this->projects[0]['id']);

        if(is_null($project)) $project = Project::find($this->project_id);
        $this->trackers = $project->trackers()->select('id', 'name')->get()->toArray();
        $this->tracker_id = old('tracker_id', $this->trackers[0]['id']);

        $this->subject = old('subject');
        $this->description = old('description');

        $this->fields_bits = Tracker::find($this->tracker_id)->fields_bits;

        $query = IssueStatus::query()
                    ->select(['issue_statuses.id', 'issue_statuses.name'])
                    ->join('workflows', 'workflows.old_status_id', '=', 'issue_statuses.id')
                    ->where('workflows.tracker_id', $this->tracker_id)
                    ->groupBy('issue_statuses.id', 'issue_statuses.name');
        $this->statuses = $query->get()->toArray();
        $this->status_id = old('status_id', $query->first()->id);


        $this->priorites = Enumeration::query()
                                ->select('id', 'name')
                                ->whereType(Type::ISSUE_PRIORITY)
                                ->orderBy('position', 'asc')
                                ->get()->toArray();
        $this->priority_id = old('priority_id',
                                 Enumeration::query()
                                    ->whereType(Type::ISSUE_PRIORITY)
                                    ->whereIsDefault(true)
                                    ->first()->id);

        $this->assignments = $project->assignings->pluck('name', 'id')->toArray();
        $this->watchers = $project->watchers->pluck('name', 'id')->toArray();

        $this->parent_id = old('parent_id');
        $this->start_date = old('start_date');
        $this->due_date = old('due_date');
        $this->done_raito = old('done_raito');
    }

    public function updatedProjectId()
    {
        $project = Project::find($this->project_id);

        $this->trackers = $project->trackers()->select('id', 'name')->get()->toArray();
        $this->tracker_id = $this->trackers[0]['id'];

        $this->updatedTrackerId();

        $this->assignments = $project->assignings->pluck('name', 'id')->toArray();
        $this->watchers = $project->watchers->pluck('name', 'id')->toArray();
    }

    public function updatedTrackerId()
    {
        $this->fields_bits = Tracker::find($this->tracker_id)->fields_bits;

        $query = IssueStatus::query()
                    ->select(['issue_statuses.id', 'issue_statuses.name'])
                    ->join('workflows', 'workflows.old_status_id', '=', 'issue_statuses.id')
                    ->where('workflows.tracker_id', $this->tracker_id)
                    ->groupBy('issue_statuses.id', 'issue_statuses.name');
        $this->statuses = $query->get()->toArray();
        $this->status_id = $query->first()->id;
    }

    public function render()
    {
        return view('livewire.issue-add');
    }
}
