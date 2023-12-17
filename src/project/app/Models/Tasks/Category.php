<?php


namespace App\Models\Tasks;


use App\Core\BaseModel;
use App\Models\Users\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends BaseModel
{

    protected $table = 'tasks';
    protected $primaryKey = 'task_id';

    protected $fillable = [
        'name',
        'description',
        'is_active',

        //AUDIT TRAIL
        'created_at',
        'created_by',

        'updated_at',
        'updated_by',
    ];


    public function tasks(): HasMany
    {
        return $this->hasMany(TaskCategory::class, 'category_id+', 'category_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'created_by');
    }
}
