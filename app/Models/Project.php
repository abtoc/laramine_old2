<?php

namespace App\Models;

use App\Enums\ProjectStatus as Status;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Kalnoy\Nestedset\NodeTrait;

/**
 * Project
 * 
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property \App\Enums\ProjectStatus $status
 * @property boolean $inherit_members
 * @property boolean $is_public
 * @property integer $parent_id
 * @property \App\Models\Project $parent
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Support\Collection $issue_tracking 
 * @property \Illuminate\Database\Eloquent\Collection<Member> $members 
 * @property \Illuminate\Database\Eloquent\Collection<Issue> $issues 
 * @property \Illuminate\Database\Eloquent\Collection<Member> $menbers
 * @property \Illuminate\Database\Eloquent\Collection<Tracker> $trackers
 * @property \Illuminate\Database\Eloquent\Collection<User> $users
 */

class Project extends Model
{
    use HasFactory, NodeTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'status',
        'inherit_members',
        'is_public',
        'parent_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'status' => Status::class,
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    /**
     * relation
     */

    public function groups() { return $this->belongsToMany(Group::class,  'member', 'project_id', 'user_id')->using(Member::class)->withPivot(['id']); }
    public function issues() { return $this->hasMany(Issue::class); }
    public function members() { return $this->hasMany(Member::class); }
    public function trackers() { return $this->belongsToMany(Tracker::class, 'projects_trackers'); }
    public function users() { return $this->belongsToMany(User::class,  'member')->using(Member::class)->withPivot(['id']); }

    /**
     * root project
     */
    protected function root(): Attribute
    {
        return Attribute::make(
            get: function(){
                $root = $this;
                while($root->parent){
                    $root = $root->parent;
                }
                return $root;
            }
        )->shouldCache();
    }
    
     /**
     * issue tracking
     */
    protected function issueTracking(): Attribute
    {
        return Attribute::make(
            get: function(){
                $tracking = collect([]);
                $ids = Project::select('id')
                    ->where('_lft', '>=', $this->_lft)
                    ->where('_rgt', '<=', $this->_rgt)
                    ->get()
                    ->pluck('id')
                    ->toArray();
                $query = Tracker::query();
                foreach($query->cursor() as $tracker){
                    $tracking->push((object)[
                        'tracker' => $tracker,
                        'pending' => Issue::query()
                                        ->whereIn('project_id', $ids)
                                        ->whereTrackerId($tracker->id)
                                        ->whereNull('closed_at')
                                        ->count(),
                        'completed' => Issue::query()
                                        ->whereIn('project_id', $ids)
                                        ->whereTrackerId($tracker->id)
                                        ->whereNotNull('closed_at')
                                        ->count(),
                        'total' => Issue::query()
                                        ->whereIn('project_id', $ids)
                                        ->whereTrackerId($tracker->id)
                                        ->count(),
                    ]);
                }
                return $tracking;
            }
        )->shouldCache();
    }

    /**
     * assignings
     */
    protected function assignings(): Attribute
    {
        return Attribute::make(
            get: function(){
                $users = collect([Auth::user()]);
                $project = $this;
                while($project){
                    $users = $users->concat($project->users)->unique('id');
                    foreach($project->groups as $group){
                        $users = $users->concat($group->users)->unique('id');
                    }
                    if(!$project->inherit_members) break;
                    $project = $project->parent;
                }
                return $users->sortBy('name');
            }
        )->shouldCache();
    }

    /**
     * watchers
     */
    protected function watchers(): Attribute
    {
        return Attribute::make(
            get: function(){
                $users = collect([]);
                $project = $this;
                while($project){
                    $users = $users->concat($project->users)->unique('id');
                    $users = $users->concat($project->groups)->unique('id');
                    if(!$project->inherit_members) break;
                    $project = $project->parent;
                }
                return $users->sortBy('name');
            }
        )->shouldCache();
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->status === Status::ACTIVE;
    }

    /**
     * @return bool
     */
    public function isArchive(): bool
    {
        return $this->status === Status::ARCHIVE;
    }

    /**
     * Get sub projects with out archive
     * 
     * @return array
     */
    public function getSubProjects()
    {
        return $this->children()
                    ->where('status', '<>', Status::ARCHIVE)
                    ->get()->filter(function($value, $key){
                        return Auth::check() or $value->is_public;
                    });
    }

    /**
     * Join User
     *
     * @param  \App\Models\User    $user
     * @return bool
     */
    public function isJoining($user)
    {
        if(is_null($user))  return false;

        $project = $this;
        while($project){
            $query = Member::query()
                        ->whereProjectId($project->id)
                        ->where(function($q) use($user){
                            $q->whereUserId($user->id)
                              ->orWhereIn('user_id', function($q) use($user){
                                    $q->select('group_id')->from('groups_users')->where('user_id', $user->id);
                              });
                        });
            
            if($query->exists())    return true;

            if(!$project->inherit_members) break;
            $project = $project->parent;
        }
 
        return false;
    }

    /**
     * Active Project
     * 
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->whereStatus(Status::ACTIVE);
    }

    /**
     * Active or Closed Project
     * 
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActiveOrClosed($query)
    {
        return $query->whereIn('status', [Status::ACTIVE, Status::CLOSED]);
    }

    /**
     * The "booting" method of the model
     * 
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        self::creating(function($project){
            if(is_null($project->status)){
                $project->status = Status::ACTIVE;
            }
            if(is_null($project->parent_id)){
                $project->inherit_members = false;
            } elseif(is_null($project->inherit_members)){
                $project->inherit_members = true;
            }
        });

        self::created(function($project){
            $project->trackers()->sync(
                Tracker::all()->pluck('id')->toArray()
            );
        });

        self::updating(function($project){
            if($project->isDirty('parent_id')){
                if(is_null($project->parent_id)){
                    $project->inherit_members = false;
                }
            }
        });
    }

    /**
     * Retrieve the model for a bound value.
     *
     * @param  mixed  $value
     * @param  string|null  $field
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function resolveRouteBinding($value, $field = null)
    {
        return static::withOutGlobalScope('project')->where($field ?? 'id', $value)->first();
    }

    /**
     * The "bootted" method of the model
     * 
     * @return void
     */
    protected static function booted()
    {
        parent::booted();
        
        static::addGlobalScope('project', function(Builder $builder){
            $builder->where('status',  '<>', Status::ARCHIVE);
        });
    }
}
