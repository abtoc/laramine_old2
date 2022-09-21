<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\UserStatus;
use App\Enums\UserType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use PhpParser\Node\Expr\BinaryOp\BooleanOr;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

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
        'last_login_at' => 'datetime',
        'password_change_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * return bool
     */
    public function isUser(): bool
    {
        return $this->type === UserType::USER;
    }

    /**
     * return bool
     */
    public function isGroup(): bool
    {
        return $this->type === UserType::GROUP;
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
     * The "booting" method of the model
     * 
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        self::creating(function($user){
            if($user->type === UserType::USER){
                $user->password_change_at = now();
            } else {
                $user->login = "";
                $user->email = "";
                $user->password = "";
                $user->must_change_password = false;
            }
        });

        self::updating(function($user){
            if($user->isDirty('password')){
                $user->must_change_password = false;
                $user->password_change_at = now();
            }
        });
    }
}
