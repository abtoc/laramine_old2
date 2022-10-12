<?php

namespace App\Models;

use App\Enums\UserStatus;
use App\Enums\UserType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Group
 * 
 * @property integer $id
 * @property \App\Enums\UserType $type
 * @property string $name
 * @property \App\Enums\UserStatus $status
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Illuminate\Database\Eloquent\Collection<User> $users
 */

class Group extends Model
{
    use HasFactory;

    /**
     * Table Name
     * 
     * @var string
     */
    protected $table = "users";

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /** The attributes that should be cast.
    *
    * @var array<string, string>
    */
   protected $casts = [
       'type' => UserType::class,
       'email_verified_at' => 'datetime',
       'status' => UserStatus::class,
   ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $dates = [
        'last_login_at',
        'password_change_at',
        'created_at',
        'updated_at',
    ];

    /**
     * relations
     */

    public function members() { return $this->hasMany(Member::class); }
    public function projects() { return $this->belongsToMany(User::class,  'members')->using(Member::class)->withPivot(['id']); }
    public function users() { return $this->belongsToMany(User::class, 'groups_users'); }

    /**
     * return bool
     * @return bool
     */
    public function isGroup($only=false): bool
    {
        if($only){
            return $this->type === UserType::GROUP;
        }
        return in_array($this->type, [UserType::GROUP, UserType::GROUP_ANONYMOUS, UserType::GROUP_NON_MEMBER, UserType::ANONYMOUS_USER]);
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->status === UserStatus::ACTIVE;
    }

    /**
     * @return bool
     */
    public function isLocked(): bool
    {
        return $this->status === UserStatus::LOCKED;
    }

    /**
     * @return bool
    */
    public function isDelete(): bool
    {
        return $this->type === UserType::GROUP;
    }

    /**
     * @param \App\Models\User $user
     * @return bool
     */
    public function hasUser($user): bool
    {
        $query = DB::table('groups_users')
            ->whereGroupId($this->id)
            ->whereUserId($user->id);
        return $query->exists();
    }

    /**
     * Active Group
     * 
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->whereStatus(UserStatus::ACTIVE);
    }

    /**
     * The "booting" method of the model
     * 
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        self::creating(function($user){
            if(is_null($user->type)){
                $user->type = UserType::GROUP;
            }
            if(is_null($user->status)){
                $user->status = UserStatus::ACTIVE;
            }
            $user->login = "";
            $user->email = "";
            $user->password = "";
            $user->must_change_password = false;
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
        
        static::addGlobalScope('group', function(Builder $builder){
            $builder->whereIn('type',  [UserType::GROUP, UserType::GROUP_ANONYMOUS, UserType::GROUP_NON_MEMBER]);
        });
    }
}
