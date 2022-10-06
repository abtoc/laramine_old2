<?php

namespace App\Models;

use App\Enums\ProjectStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Kalnoy\Nestedset\NodeTrait;

use function PHPSTORM_META\map;

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
        'status' => ProjectStatus::class,
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
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->status === ProjectStatus::ACTIVE;
    }

    /**
     * @return bool
     */
    public function isArchive(): bool
    {
        return $this->status === ProjectStatus::ARCHIVE;
    }

    /**
     * Get sub projects with out archive
     * 
     * @return array
     */
    public function getSubProjects()
    {
        return $this->children()
                    ->where('status', '<>', ProjectStatus::ARCHIVE)
                    ->get()->filter(function($value, $key){
                        return Auth::check() or $value->is_public;
                    });
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
                $project->status = ProjectStatus::ACTIVE;
            }
            if(is_null($project->parent_id)){
                $project->inherit_members = false;
            } elseif(is_null($project->inherit_members)){
                $project->inherit_members = true;
            }
        });

        self::updating(function($project){
            if($project->isDirty('parent_id')){
                if(is_null($project->parent_id)){
                    $project->inherit_members = false;
                }
            }
        });
    }
}
