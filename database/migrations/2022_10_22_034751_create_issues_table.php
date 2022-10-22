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
        Schema::create('issues', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(App\Models\Project::class);
            $table->foreignIdFor(App\Models\Tracker::class);
            $table->string('subject');
            if(config('database.default') === 'sqlite'){
                $table->text('description')->nullable();

            } else {
                $table->text('description')->fulltext()->nullable();
            }
            $table->foreignIdFor(App\Models\IssueStatus::class, 'status_id');
            $table->unsignedBigInteger('priority_id');
            $table->foreignIdFor(App\Models\User::class, 'author_id');
            $table->foreignIdFor(App\Models\User::class, 'assigned_to_id')->nullable();
            $table->date('start_date')->nullable();
            $table->date('due_date')->nullable();
            $table->boolean('is_private')->default(false);
            $table->tinyInteger('done_raito')->default(0);
            $table->unsignedBigInteger('root_id')->nullable()->index();
            $table->unsignedBigInteger('parent_id')->nullable()->index();
            $table->unsignedBigInteger('_lft')->nullable();
            $table->unsignedBigInteger('_rgt')->nullable();
            $table->dateTime('closed_at');
            $table->timestamps();

            $table->index('created_at');
            $table->index(['root_id', '_lft', '_rgt']);

            $table->foreign('project_id')
                ->on('projects')
                ->references('id');
            $table->foreign('tracker_id')
                ->on('trackers')
                ->references('id');
            $table->foreign('status_id')
                ->on('issue_statuses')
                ->references('id');
            $table->foreign('priority_id')
                ->on('enumerations')
                ->references('id');
            $table->foreign('author_id')
                ->on('users')
                ->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('issues');
    }
};
