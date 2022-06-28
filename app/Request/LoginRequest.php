<?php

namespace App\Request;

class LoginRequest extends FormRequest
{
    function rules(): void
    {
        $this->validator
            ->requirePresence('email', 'This field is required')
            ->notEmptyString('email', 'Email is required')
            ->email('email', false, 'EMail must be valid')
            ->minLength('email', 3, 'Too short')
            ->maxLength('email', 60, 'Too long')
            ->requirePresence('password', 'This field is required')
            ->notEmptyString('password', 'Password is required')
            ;
    }
}
