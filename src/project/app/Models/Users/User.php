<?php


namespace App\Models\Users;


use App\Core\BaseModel;

use App\Models\Tasks\Category;
use App\Models\Tasks\Task;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

use Illuminate\Database\Eloquent\Builder;

class User extends BaseModel
{


    protected $table = 'users';
    protected $primaryKey = 'user_id';
    public $timestamps = false;


    protected $guarded = ['password'];

    protected $fillable = [
        'public_user_id',
        'first_name',
        'middle_name',
        'last_name',
        'email',
        'password',

        'nationality_id',
        'date_of_birth',
        'is_active',

        //AUDIT TRAIL
        'created_at',
        'created_by',

        'updated_at',
        'updated_by',
    ];

    public static function boot(): void
    {
        parent::boot();

        static::creating(function (BaseModel $instance)
        {
            $instance->public_user_id = self::generateUniquePublicUserId();
        });
    }


    private static function generateUniquePublicUserId(): string
    {
        $carbon = Carbon::now();
        $randomId = Str::random(4);

        $publicUserId = 'USR' . $carbon->year . $carbon->month . 'C' . $randomId;

        if (self::query()
                ->forPublicUserId($publicUserId)
                ->exists())
        {
            return self::generateUniquePublicUserId();
        }

        return $publicUserId;
    }


    public function categories(): HasMany
    {
        return $this->hasMany(Category::class, 'created_by', 'user_id');
    }


    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class, 'created_by', 'user_id');
    }

    public function tickets(): HasMany
    {
        return $this->hasMany(UserTicket::class, 'created_by', 'user_id');
    }


    public function scopeForPublicUserId(Builder $query, string $publicUserId): void
    {
        $query->where($this->table . '.public_user_id', '=', $publicUserId);
    }

    public function scopeForEmail(Builder $query, string $email)
    {
        $query->where($this->table . '.email', $email);
    }

    public function scopeActive(Builder $query, bool $isActive = true)
    {
        $query->where($this->table . '.is_active1', $isActive ? 1 : 0);
    }

}
