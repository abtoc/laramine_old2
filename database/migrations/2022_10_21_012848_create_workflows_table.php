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
        Schema::create('workflows', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tracker_id')->index()->default(0);
            $table->unsignedBigInteger('old_status_id')->index()->default(0);
            $table->unsignedBigInteger('new_status_id')->index()->default(0);
            $table->timestamps();

            $table->index(['tracker_id', 'old_status_id']);

            $table->foreign('tracker_id')
                ->on('trackers')
                ->references('id')
                ->cascadeOnDelete();
            $table->foreign('old_status_id')
                ->on('issue_statuses')
                ->references('id')
                ->cascadeOnDelete();
            $table->foreign('new_status_id')
                ->on('issue_statuses')
                ->references('id')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('workflows');
    }
};
