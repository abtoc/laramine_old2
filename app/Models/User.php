<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\UserStatus;
use App\Enums\UserType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Kyslik\ColumnSortable\Sortable;

/**
 * User
 * 
 * @property integer $id
 * @property \App\Enums\UserType $type
 * @property string $name
 * @property string $login
 * @property string $email
 * @property \Carbon\Carbon $email_verified_at
 * @property string $password
 * @property \App\Enums\UserStatus $status
 * @property boolean $admin
 * @property boolean $admin_users
 * @property boolean $admin_projects
 * @property boolean $must_change_password
 * @property string $remember_token
 * @property \Carbon\Carbon $last_login_at
 * @property \Carbon\Carbon $password_change_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Illuminate\Database\Eloquent\Collection<Issue> $authors
 * @property \Illuminate\Database\Eloquent\Collection<Issue> $assignments
 * @property \Illuminate\Database\Eloquent\Collection<Group> $groups
 * @property \Illuminate\Database\Eloquent\Collection<Project> $projects
 * @property \Illuminate\Database\Eloquent\Collection<Member> $members 
 */

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Sortable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'type',
        'name',
        'login',
        'email',
        'password',
        'status',
        'admin',
        'admin_users',
        'admin_projects',
        'must_change_password',
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

    /**
     * The attributes that should be cast.
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
     * The attributes that should be sort
     *
     * @var array<string>
     */
    public $sortable = [
        'login',
        'name',
        'admin',
        'created_at',
        'last_login_at'
    ];

    /**
     * relations
     */

    public function authors()  { return $this->hasMany(Issue::class, 'author_id'); }
    public function assignments() { return $this->hasMany(Issue::class, 'assigned_to_id'); }
    public function groups() { return $this->belongsToMany(Group::class, 'groups_users'); }
    public function members() { return $this->hasMany(Member::class); }
    public function projects() { return $this->belongsToMany(User::class,  'member')->using(Member::class)->withPivot(['id']); }

    /**
     * return bool
     */
    public function isUser(): bool
    {
        return $this->type === UserType::USER;
    }

    /**
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->admin;
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
    public function isRegisterd(): bool
    {
        return $this->status === UserStatus::REGISTERD;
    }

    /**
     * @return bool
     */
    public function isLocked(): bool
    {
        return $this->status === UserStatus::LOCKED;
    }

    /**
     * Active User
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
            $user->type = UserType::USER;
            $user->password_change_at = now();
        });

        self::updating(function($user){
            if($user->isDirty('password')){
                $user->must_change_password = false;
                $user->password_change_at = now();
            }
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
        
        static::addGlobalScope('user', function(Builder $builder){
            $builder->whereIn('type',  [UserType::USER]);
        });
    }
}
