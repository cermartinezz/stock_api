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
 * @property string $full_name
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

    /**
     * Get the user's full_name
     *
     * @return string
     */
    public function getFullNameAttribute(): string
    {
        $first_name = Str::ucfirst($this->first_name);
        $last_name = Str::ucfirst($this->last_name);

        return "$first_name $last_name";
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'name' => $this->full_name,
        ];
    }


}
