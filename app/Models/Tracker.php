<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

/**
 * Tracker
 * 
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property integer $position
 * @property integer $issue_status_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */

class Tracker extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'position',
        'issue_status_id',
    ];

    /**
     * Relation
     */
    public function issue_status() { return $this->belongsTo(IssueStatus::class); }

    /**
     * The "booting" method of the model
     * 
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        self::creating(function($tracker){
            if(is_null($tracker->position)){
                $tracker->position = Tracker::max('position') + 1;
            }
        });
        self::updating(function($tracker){
            if($tracker->isDirty('position')){
                $from = $tracker->getOriginal('position');
                $to   = $tracker->position;
                if($from < $to){
                    DB::update('update trackers set position = position - 1 where position > ? and position <= ?', [$from, $to]);
                } elseif($from > $to){
                    DB::update('update trackers set position = position + 1 where position >= ? and position < ?', [$to, $from]);
                }
            }
        });
        self::deleted(function($tracker){
            DB::update('update trackers set position = position - 1 where position > ?', [$tracker->position]);
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
        
        static::addGlobalScope('tracker', function(Builder $builder){
            $builder->orderBy('position', 'asc');
        });
    }
}
