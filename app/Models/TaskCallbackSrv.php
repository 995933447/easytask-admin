<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskCallbackSrv extends Model
{
    use HasFactory;

    protected $table = "task_callback_srv";

    public function routes() {
        return $this->hasMany(TaskCallbackSrvRoute::class, "srv_id", "id");
    }

    public function tasks() {
        return $this->hasMany(Task::class, "callback_srv_id", "id");
    }
}
