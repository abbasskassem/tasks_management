<?php


namespace App\Models\Users;


use App\Core\BaseModel;

use App\Models\Tasks\Task;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;


class UserTicket extends BaseModel
{


    protected $table = 'user_tickets';
    protected $primaryKey = 'user_ticket_id';


    public const STATUS_PENDING = 'pending';
    public const STATUS_DONE = 'done';
    public const STATUS_CANCELLED = 'cancelled';
    public const STATUS_SNOOZED = 'snoozed';

    //IN PROGRESS or any status ..

    protected $fillable = [
        'parent_user_ticket_id',
        'user_id',
        'task_id',
        'assigner_user_id',
        'status',
        'assignment_datetime',
        'due_date',
        'done_datetime',
        'cancellation_datetime',
        'snooze_datetime',

        //AUDIT TRAIL
        'created_at',
        'created_by',

        'updated_at',
        'updated_by',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'created_by');
    }

    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class, 'task_id', 'task_id');
    }


    public function scopeForTask($query, int $taskId)
    {
        $query->where($this->table . '.task_id', $taskId);
    }

    public function scopeForUser($query, int $userId)
    {
        $query->where($this->table . '.user_id', $userId);
    }


    public function scopeStillActive($query)
    {
        $query->whereIn($this->table . '.status', [self::STATUS_PENDING, self::STATUS_SNOOZED]);
    }

    public function scopePassedDue($query)
    {
        $dateFilterCondition = Carbon::now()->toDateString();
        return $query->where($dateFilterCondition, '>=', DB::raw('DATE(`due_date`)'));
    }
}
