<?php

namespace App\Core\ModelTraits;

use App\Core\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

trait BaseSoftDeleteTrait
{
    use SoftDeletes;



    protected function runSoftDelete(): void
    {
        $query = $this->newModelQuery()
                      ->where($this->getKeyName(), $this->getKey());

        $time = $this->freshTimestamp();


        $userId = BaseModel::getAuthenticatedUserId();

        $columns = [
            $this->getDeletedAtColumn() => $this->fromDateTime($time),
            $this->getDeleteByColumn() => $userId,
        ];


        $this->{$this->getDeletedAtColumn()} = $time;
        $this->{$this->getDeleteByColumn()} = $userId;


        $query->update($columns);
    }

    public function getDeleteByColumn(): string
    {
        return BaseModel::DELETED_BY_COLUMN;
    }


    public function getDeletedAtColumn(): string
    {
        return BaseModel::DELETED_AT_COLUMN;
    }
}
