<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Task extends Model
{
    use HasFactory;

    public const STATUS_BACKLOG  = 'backlog';
    public const STATUS_WIP      = 'wip';
    public const STATUS_DONE     = 'done';
    public const STATUS_CANCELED = 'cancelled';

    public const STATUSES = [
        self::STATUS_BACKLOG,
        self::STATUS_WIP,
        self::STATUS_DONE,
        self::STATUS_CANCELED
    ];

    protected $guarded = [];

    public const VALIDATOR_RULES = [
        'task_id' => 'required|exists:App\Models\Task,id',
    ];

    public static function getValidStatus(Request $request): string
    {
        $status = $request->status;
        if (in_array($status, self::STATUSES)) {
            return $status;
        }

        return self::STATUS_BACKLOG;
    }
}
