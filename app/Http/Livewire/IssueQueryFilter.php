<?php

namespace App\Http\Livewire;

use App\Enums\EnumerationType as Type;
use App\Models\IssueStatus;
use App\Models\Enumeration;
use App\Models\Project;
use App\Models\Tracker;
use Livewire\Component;

class IssueQueryFilter extends Component
{
    public $filters = [];
    public $operations = [];
    public $values;
    public $items;
    public $addFilterSelect;
    public $operation_names = [
    ];

    public $conditions = [
        'status' => [
            'o'  => null,
            '='  => 'getStatuses',
            '!'  => 'getStatuses',
            'c'  => null,
            '*'  => null,         
        ],
        'project' => [
            '='   => 'getProjects',
            '!'   => 'getProjects',
        ],
        'tracker' => [
            '='   => 'getTrackers',
            '!'   => 'getTrackers',
        ],
        'priority' => [
            '='   => 'getPriorites',
            '!'   => 'getPriorites',
        ],
        'done_raito' => [
            '='   => ['number'],
            '>='  => ['number'],
            '<='  => ['number'],
            '><'  => ['number', 'number'],
            '!'   => null,
            '*'   => null,
        ],
    ];

    protected function getStatuses()
    {
        return IssueStatus::query()
                ->orderBy('position', 'asc')
                ->get()->pluck('name', 'id');
    }

    protected function getPriorites()
    {
        return Enumeration::query()
                ->whereType(Type::ISSUE_PRIORITY)
                ->orderBy('position', 'asc')
                ->get()->pluck('name', 'id');
    }

    protected function getProjects()
    {
        return collect([
            ['id' => 'mine', 'name' => '<< '.__('My Project').' >>'],
            ['id' => 'bookmark', 'name' => '<< '.__('My Bookmark').' >>'],
        ])->concat(
            Project::query()
                ->orderBy('name', 'asc')
                ->get()
        )->pluck('name', 'id');
    }

    protected function getTrackers()
    {
        return Tracker::query()
                ->orderBy('position', 'asc')
                ->get()->pluck('name', 'id');
    }

    public function updatedOperations($op, $f)
    {
        $items = $this->conditions[$f][$op];
        switch(gettype($items)){
            case 'array':
                $str = '<div class="input-group">';
                foreach($items as $i => $item){
                    $value = ($i + 1) > count($this->values[$f]) ? '' : $this->values[$f][$i];
                    switch($item){
                        case 'number':
                            $str .= '<input type="number" name="v['.$f.']" class="form-control form-control-sm" value="'.$value.'" reguired>'.PHP_EOL;
                            break;
                        case 'date':
                            $str .= '<input type="date" name="v['.$f.']" class="form-control form-control-sm" value="'.$value.'" required>'.PHP_EOL;
                            break;
                        case 'date':
                            $str .= '<input type="date" name="v['.$f.']" class="form-control form-control-sm" value="'.$value.'" required>'.PHP_EOL;
                            break;
                    }
                }
                $str .= '</div>'.PHP_EOL;
                break;
            case 'string':
                $func = array($this, $items);
                $items = $func();
                $str = '<select name="v['.$f.']" class="form-select form-select-sm" id="filter-value-'.$f.'">'.PHP_EOL;
                foreach($items as $id => $name){
                    $str .= '<option value="'.$id.'" '.(in_array($id, $this->values[$f])? 'selected' : '').'>'.$name.'</option>'.PHP_EOL;
                }
                $str .= '</select>'.PHP_EOL;
                break;
            default:
                $str = '';
        }
        $this->items[$f] = $str;
    }

    public function updatedAddFilterSelect($f)
    {
        $this->addFilter($f);
    }

    protected function addFilter($f, $op=null, $v=null)
    {
        if(!array_key_exists($f, $this->conditions)) return;
        if(array_key_exists($f, $this->filters)) return;

        if(is_null($op)){
            $op = array_key_first($this->conditions[$f]);
        }
        $this->filters[] = $f;
        $this->operations[$f] = $op;
        $this->values[$f] = is_null($v) ? [] : $v;

        $this->updatedOperations($op, $f);
    }

    public function mount()
    {
        $this->operation_names = [
            '='     => __('eq'),
            '!'     => __('other'),
            '>='    => __('ge'),
            '<='    => __('le'),
            '><'    => __('bettween'),
            'o'     => __('pending'),
            'c'     => __('completed'),
            '*'     => __('all'),
        ];

        foreach(request()->input('f', []) as $f){
            $op = request()->input('op.'.$f, null);
            $v  = request()->input('v.'.$f, null);

            $this->addFilter($f, $op, $v);
        }
    }

    public function render()
    {
        return view('livewire.issue-query-filter');
    }
}
