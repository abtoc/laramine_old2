<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workflow extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'tracker_id',
        'old_status_id',
        'new_status_id',
    ];

    /**
     * relation
     */
    public function tracker() { return $this->belongsTo(Tracker::class); }
    public function old_status() { return $this->belongsTo(IssueStatus::class, 'old_status_id'); }
    public function new_status() { return $this->belongsTo(IssueStatus::class, 'new_status_id'); }
}
