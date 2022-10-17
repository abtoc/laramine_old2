<?php

namespace App\Models;

use App\Enums\EnumerationType as Type;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Enumration
 * 
 * @property integer $id
 * @property string $name
 * @property \App\Enums\EnumerationType $type
 * @property integer $position
 * @property boolean $is_default
 * @property boolean $active
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Enumeration extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'type',
        'position',
        'is_default',
        'active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'type' => Type::class,
    ];

    /**
     * Active
     * 
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->whereActive(true);
    }

    /**
     * Has Type
     * 
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  \App\Enums\EnumerationType $type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeHasType($query, Type $type)
    {
        return $query->whereType($type);
    }

    /**
     * The "booting" method of the model
     * 
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        self::creating(function($enum){
            if(is_null($enum->position)){
                $enum->position = Enumeration::whereType($enum->type)->max('position') + 1;
            }
        });
        self::updating(function($enum){
            if($enum->isDirty('position')){
                $from = $enum->getOriginal('position');
                $to   = $enum->position;
                if($from < $to){
                    DB::update('update enumerations set position = position - 1 where type = ? and position > ? and position <= ?', [$enum->type->value, $from, $to]);
                } elseif($from > $to){
                    DB::update('update enumerations set position = position + 1 where type = ? and position >= ? and position < ?', [$enum->type->value, $to, $from]);
                }
            }
        });
        self::deleted(function($enum){
            DB::update('update enumerations set position = position - 1 where type = ? and position > ?', [$enum->type->value, $enum->position]);
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
        
        static::addGlobalScope('other', function(Builder $builder){
            $builder->orderBy('position', 'asc');
        });
    }
}
