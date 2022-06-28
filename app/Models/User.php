<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

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
        $user->password = $data['password'];
        $user->save();

        return $user;
    }

    /**
     * Set the user's password
     *
     * @param string $value
     * @return void
     */
    public function setPasswordAttribute(string $value): void
    {
        $this->attributes['password'] = password_hash($value, PASSWORD_BCRYPT);
    }

    /**
     * Set the user's password
     *
     * @param string $value
     * @return void
     */
    public function setEmailAttribute(string $value): void
    {
        $this->attributes['email'] = Str::lower($value);
    }
}
