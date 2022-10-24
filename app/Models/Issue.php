<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Kalnoy\Nestedset\NodeTrait;

/**
 * Issue
 * 
 * @property integer $id
 * @property integer $project_id
 * @property integer $tracker_id
 * @property string $subject
 * @property string $description
 * @property integer $status_id
 * @property integer $priority_id
 * @property integer $author_id
 * @property integer $assigned_to_id
 * @property \Carbon\Carbon $start_date
 * @property \Carbon\Carbon $due_date
 * @property boolean $is_private
 * @property integer $done_rate
 * @property integer $root_id
 * @property integer $parent_id
 * @property integer $_lft
 * @property integer $_rgt
 * @property \Carbon\Carbon $closed_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \App\Models\Issue $parent
 * @property \App\Models\Project $project
 * @property \App\Models\Tracker $tracker
 * @property \App\Models\IssueStatus $status
 * @property \App\Models\Enumeration $priority
 * @property \App\Models\User $author
 */

class Issue extends Model
{
    use HasFactory, Sortable, NodeTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'project_id',
        'tracker_id',
        'subject',
        'description',
        'status_id',
        'priority_id',
        'author_id',
        'assigned_to_id',
        'start_date',
        'due_date',
        'is_private',
        'done_raito',
        'parent_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $dates = [
        'start_date',
        'due_date',
        'closed_at',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be sort
     *
     * @var array<string>
     */
    public $sortable = [
        'id',
        'project_id',
        'tracker_id',
        'status_id',
        'priority_id',
        'subject',
        'author_id',
        'assigned_to_id',
        'start_date',
        'due_date',
        'closed_at',
        'created_at',
        'updated_at',
    ];

    /**
     * Relation
     */
    public function project() { return $this->belongsTo(Project::class); }
    public function tracker() { return $this->belongsTo(Tracker::class); }
    public function status()  { return $this->belongsTo(IssueStatus::class, 'status_id'); }
    public function priority() { return $this->belongsTo(Enumeration::class, 'priority_id'); }
    public function author()  { return $this->belongsTo(User::class, 'author_id'); }

    /**
     * The "booting" method of the model
     * 
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        self::saving(function($issue){
            if($issue->status->is_closed){
                $issue->closed_at = Carbon::now();
            } else {
                $issue->closed_at = null;
            }
        });
    }
}
