<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

}
