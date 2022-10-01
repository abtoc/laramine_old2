<?php

use App\Enums\UserStatus;
use App\Enums\UserType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('name');
            $table->string('login')->index();
            $table->string('email')->index();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->unsignedTinyInteger('status')->default(UserStatus::ACTIVE->value);
            $table->boolean('admin')->default(false);
            $table->boolean('admin_users')->default(false);
            $table->boolean('admin_projects')->default(false);
            $table->boolean('must_change_password')->default(false);
            $table->rememberToken();
            $table->dateTime('last_login_at')->nullable();
            $table->dateTime('password_change_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
