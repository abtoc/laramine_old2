<?php

namespace App\Models;

use App\Enums\UserStatus;
use App\Enums\UserType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function users() { return $this->belongsToMany(User::class, 'groups_users', 'group_id', 'user_id'); }

    /**
     * return bool
     * @return bool
     */
    public function isGroup(): bool
    {
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
}
