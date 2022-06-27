<?php

namespace App\Request;

class LoginRequest extends FormRequest
{
    function rules(): void
    {
        $this->validator
            ->requirePresence('email', 'This field is required')
            ->notEmptyString('email', 'Email is required')
            ->minLength('email', 3, 'Too short')
            ->maxLength('email', 60, 'Too long')
            ->requirePresence('password', 'This field is required')
            ->notEmptyString('password', 'Password is required')
            ->minLength('password', 8, 'Too short')
            ->maxLength('password', 60, 'Too long')
            ->requirePresence('email', 'This field is required')
            ->email('email', false, 'E-Mail must be valid')
            ->notEmptyString('mobile', 'Mobile number must not be empty')
            ->regex('mobile', '/^\+[0-9]{6,}$/', 'Invalid mobile number');
    }
}
