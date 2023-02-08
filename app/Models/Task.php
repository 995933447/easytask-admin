<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $table = "task";

    const SCHED_MODE_SPEC = 1;
    const SCHED_MODE_CRON_EXPR = 2;
    const SCHED_MODE_INTERVAL = 3;

    public function logs() {
        return $this->hasMany(TaskLog::class, "task_id", "id");
    }

    public function server() {
        return $this->belongsTo(TaskCallbackSrv::class, "callback_srv_id", "id");
    }
}
