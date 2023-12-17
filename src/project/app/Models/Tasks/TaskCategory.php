<?php


namespace App\Models\Tasks;


use App\Core\ModelTraits\BaseSoftDeleteTrait;
use App\Core\BaseModel;

class TaskCategory extends BaseModel
{

    use BaseSoftDeleteTrait;

    protected $table = 'task_categories';
    protected $primaryKey = 'task_category_id';

    protected $fillable = [
        'task_id',
        'category_id',

        //AUDIT TRAIL
        'created_at',
        'created_by',


        'deleted_by',
        'deleted_at',
    ];


    public function scopeForTask($query, int $taskId)
    {
        $query->where($this->table . '.task_id', $taskId);
    }

    public function scopeForCategory($query, int $categoryId)
    {
        $query->where($this->table . '.category_id', $categoryId);
    }
}
