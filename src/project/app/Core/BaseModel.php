<?php

namespace App\Core;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{

    private static ?int $authenticatedUserId = null;

    public const CREATED_AT_COLUMN = 'created_at';
    public const CREATED_BY_COLUMN = 'created_by';


    public const UPDATED_AT_COLUMN = 'updated_at';
    public const UPDATED_BY_COLUMN = 'updated_by';

    public const DELETED_AT_COLUMN = 'deleted_at';
    public const DELETED_BY_COLUMN = 'deleted_by';

    //TO AVOID any change later.. //TODO this should be cleaned ..
    protected const DELETED_AT = 'deleted_at';

    //DISABLED THIS TO HANDLE THIS BY US
    public $timestamps = false;


    public static function getAuthenticatedUserId(): ?int
    {
        return self::$authenticatedUserId;
    }

    public static function setAuthenticatedUserId(int $userId): void
    {
        self::$authenticatedUserId = $userId;
    }


    public static function boot(): void
    {
        parent::boot();

        static::creating(function (BaseModel $instance)
        {
            if ($instance->attributeExistsInFillable(self::CREATED_BY_COLUMN))
            {
                $instance[self::CREATED_BY_COLUMN] = self::getAuthenticatedUserId();
                //$instance->{self::CREATED_AT_COLUMN} = self::getAuthenticatedUserId();
            }


            if ($instance->attributeExistsInFillable(self::CREATED_AT_COLUMN))
            {
                $instance[self::CREATED_AT_COLUMN] = Carbon::now()
                                                           ->toDateTimeString();


            }


        });

        static::updating(function ($instance)
        {
            if ($instance->attributeExistsInFillable(self::UPDATED_BY_COLUMN))
            {
                $instance[self::UPDATED_BY_COLUMN] = self::$authenticatedUserId;
            }

            if ($instance->attributeExistsInFillable(self::UPDATED_AT_COLUMN))
            {
                $instance[self::UPDATED_AT_COLUMN] = Carbon::now()
                                                           ->toDateTimeString();
            }

        });

    }


    public function attributeExistsInFillable(string $attributeName): bool
    {
        return in_array($attributeName, $this->fillable);
    }


}
