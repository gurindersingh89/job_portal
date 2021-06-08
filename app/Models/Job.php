<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Job extends Model
{
    use HasFactory, SoftDeletes;

    public $fillable = ['title', 'description', 'qualification', 'no_of_openings', 'department', 'salary', 'job_status', 'created_by'];
    
    public $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public function scopeOpenJobs($query){
        return $query->where('job_status', 'Open');
    }

    public function scopeCloseJobs($query){
        return $query->where('job_status', 'Close');
    }
}
