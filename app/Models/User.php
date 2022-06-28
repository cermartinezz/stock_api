<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property int $id
 * @property string $password
 */
class User extends Model
{
    protected $table = 'users';

    protected $fillable = ['first_name', 'last_name', 'email'];

    protected $guarded = ['password'];

    protected $hidden = ['password'];

    public function stockHistory(): HasMany
    {
        return $this->hasMany(StockHistory::class);
    }

    public static function create(array $data): User
    {
        $user = new self($data);
        $user->password = password_hash($data['password'], PASSWORD_BCRYPT);
        $user->save();

        return $user;
    }
}
