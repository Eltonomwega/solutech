<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTasks extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','task_id','status_id','due_date','start_date','end_date','remarks'];

}
