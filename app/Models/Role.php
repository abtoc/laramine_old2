<?php

namespace App\Models;

use App\Enums\RoleBuiltin;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

/**
 * Role
 * 
 * @property integer $id
 * @property string $name
 * @property integer $position
 * @property \App\Enums\Builtin $builtin
 * @property array $permissions
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Illuminate\Database\Eloquent\Collection<Group> $groups
 */

class Role extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'permissions',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'builtin' => RoleBuiltin::class,
        'permissions' => 'json',
    ];

    /**
     * relations
     */

    public function members() { return $this->belongsToMany(Member::class, 'member_roles'); }

    /**
     * @return bool
     */
    public function isOther()
    {
        return $this->builtin === RoleBuiltin::OTHER;
    }

    /**
     * Get all of the models from the database.
     *
     * @param  array|string  $columns
     * @return \Illuminate\Database\Eloquent\Collection<int, static>
     */
    public static function all($columns = ['*'])
    {
        $roles = parent::withoutGlobalScope('other')->get($columns);
        return $roles->sortBy(fn($item, $ley) => ($item->position === 0) ? 9999 : $item->position);
    }

    /**
     * @param  array|string $names
     * @return bool
     */
    public function has($names): bool
    {
        $names = Arr::wrap($names);
        foreach($names as $name){
            if(in_array($name->value, $this->permissions)){
                return true;
            }
        }
        return false;
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
        return static::withOutGlobalScope('other')->where($field ?? 'id', $value)->first();
    }

    /**
     * The "booting" method of the model
     * 
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        self::creating(function($role){
            if(is_null($role->position)){
                $role->position = Role::max('position') + 1;
            }
        });
        self::updating(function($role){
            if($role->isDirty('position')){
                $from = $role->getOriginal('position');
                $to   = $role->position;
                if($from < $to){
                    DB::update('update roles set position = position - 1 where position > ? and position <= ?', [$from, $to]);
                } elseif($from > $to){
                    DB::update('update roles set position = position + 1 where position >= ? and position < ?', [$to, $from]);
                }
            }
        });
        self::deleted(function($role){
            DB::update('update roles set position = position - 1 where position > ?', [$role->position]);
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
            $builder->whereIn('builtin',  [RoleBuiltin::OTHER])->orderBy('position', 'asc');
        });
    }
}
