<?php

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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->unsignedTinyInteger('status')->default(1);
            $table->boolean('inherit_members')->default(false);
            $table->boolean('is_public')->default(false);
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->unsignedBigInteger('_lft')->nullable()->index();
            $table->unsignedBigInteger('_rgt')->nullable()->index();
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
        Schema::dropIfExists('projects');
    }
};
