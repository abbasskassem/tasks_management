<?php


namespace App\Models\Tasks;


use App\Core\ModelTraits\BaseSoftDeleteTrait;
use App\Core\BaseModel;
use App\Models\Users\User;
use App\Models\Users\UserTicket;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class Task extends BaseModel
{

    use BaseSoftDeleteTrait;

    protected $table = 'tasks';
    protected $primaryKey = 'task_id';

    protected $fillable = [
        'title',
        'description',

        //AUDIT TRAIL
        'created_at',
        'created_by',

        'updated_at',
        'updated_by',

        'deleted_at',
        'deleted_by',
    ];


    public function userTickets(): HasMany
    {
        return $this->hasMany(UserTicket::class, 'user_ticket_id+', 'user_ticket_id');
    }

    public function categories(): HasMany
    {
        return $this->hasMany(TaskCategory::class, 'task_id', 'task_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'created_by');
    }


    public function scopeForUser(Builder $query,int $userId) {

        $query->where($this->table.'.created_by',$userId);
    }
}
