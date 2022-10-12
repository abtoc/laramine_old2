<?php

namespace App\Models;

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
 * @property integer $buildtin
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
        'position',
        'permissions',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'permissions' => 'json',
    ];

    /**
     * relations
     */

    public function members() { return $this->belongsToMany(Member::class, 'member_roles'); }

    /**
     * Get all of the models from the database.
     *
     * @param  array|string  $columns
     * @return \Illuminate\Database\Eloquent\Collection<int, static>
     */
    public static function all($columns = ['*'])
    {
        $roles = parent::all($columns);
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

}
