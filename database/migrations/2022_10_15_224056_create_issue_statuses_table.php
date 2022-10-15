<?php

use Doctrine\DBAL\Schema\Index;
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
        Schema::create('issue_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('is_closed')->default(false)->index();
            $table->tinyInteger('position')->index();
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
        Schema::dropIfExists('issue_statuses');
    }
};
