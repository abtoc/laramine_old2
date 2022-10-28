<?php

namespace App\Http\Livewire;

use Illuminate\Support\Arr;
use Livewire\Component;

class IssueQueryOption extends Component
{
    public $available_items = [
        'project',
        'tracker',
        'subject',
        'status',
        'priority',
        'author',
        'assigned_to',
        'start_date',
        'due_date',
        'is_private',
        'done_raito',
        'closed_at',
        'created_at',
        'updated_at',
    ];
    public $available_selected = [];
    public $selected_items = [
    ];
    public $selected;

    private function addSelectItem($names)
    {
        $names = Arr::wrap($names);

        foreach($names as $name){
            $index = array_search($name, $this->available_items, true);
            if($index !== false){
                array_push($this->selected_items, $this->available_items[$index]);
                array_splice($this->available_items, $index, 1);
            }
        }
    }

    private function removeSelectItem($names)
    {
        $names = Arr::wrap($names);

        foreach($names as $name){
            $index = array_search($name, $this->selected_items, true);
            if($index !== false){
                array_push($this->available_items, $this->selected_items[$index]);
                array_splice($this->selected_items, $index, 1);
            }
        }
    }

    public function clickAddItem()
    {
        $names = Arr::wrap($this->available_selected);

        foreach($names as $name){
            $this->addSelectItem($name);
        }
    }

    public function clickRemoveItem()
    {
        $names = Arr::wrap($this->selected);

        foreach($names as $name){
            $this->removeSelectItem($name);
        }
    }

    public function clickItemUp()
    {
        $names = Arr::wrap($this->selected);
    
        foreach($names as $name){
            $index = array_search($name, $this->selected_items, true);
            if($index === false) continue;
            if($index === 0) return;
            array_move($this->selected_items, $index, $index -1);
        }
    }

    public function clickItemDown()
    {
        $names = Arr::wrap($this->selected);
        $names = array_reverse($names);
        
        foreach($names as $name){
            $index = array_search($name, $this->selected_items, true);
            if($index === false) continue;
            if($index === (count($this->selected_items) - 1)) return;
            array_move($this->selected_items, $index, $index + 1);
        }
    }

    public function mount()
    {
        foreach(request()->input('q', []) as $item){
            $this->addSelectItem($item);
        }
    }

    public function render()
    {
        return view('livewire.issue-query-option');
    }
}
