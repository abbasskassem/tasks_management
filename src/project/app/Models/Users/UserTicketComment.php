<?php


namespace App\Models\Users;


use App\Core\BaseModel;
use App\Models\Tasks\Task;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserTicketComment extends BaseModel
{

    protected $table = 'user_ticket_comments';
    protected $primaryKey = 'user_ticket_comment_id';

    protected $fillable = [
        'user_ticket_id',
        'comment',
        'created_by',
        'created_at',
    ];


    public function userTicket(): BelongsTo
    {
        return $this->belongsTo(UserTicket::class, 'user_ticket_id', 'user_ticket_id');
    }

}
