<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * IssureStatus
 * 
 * @property integer $id
 * @property string $name
 * @property bool $is_closed
 * @property integer position
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */

class IssueStatus extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'is_closed',
    ];

    /**
     * The "booting" method of the model
     * 
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        self::creating(function($issue_status){
            if(is_null($issue_status->position)){
                $issue_status->position = IssueStatus::max('position') + 1;
            }
        });
        self::updating(function($issue_status){
            if($issue_status->isDirty('position')){
                $from = $issue_status->getOriginal('position');
                $to   = $issue_status->position;
                if($from < $to){
                    DB::update('update issue_statuses set position = position - 1 where position > ? and position <= ?', [$from, $to]);
                } elseif($from > $to){
                    DB::update('update issue_statuses set position = position + 1 where position >= ? and position < ?', [$to, $from]);
                }
            }
        });
        self::deleted(function($issue_status){
            DB::update('update issue_statuses set position = position - 1 where position > ?', [$issue_status->position]);
        });
    }

    /**
     * The "bootted" method of the model
     * 
     * @return void
     */
    protected static function booted()
    {
        parent::booted();
        
        static::addGlobalScope('status', function(Builder $builder){
            $builder->orderBy('position', 'asc');
        });
    }
}
