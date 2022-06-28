<?php

namespace App\Request;

class RegisterRequest extends FormRequest
{

    function rules(): void
    {
        $this->validator
            ->requirePresence('email', 'This field is required')
            ->notEmptyString('email', 'Email is required')
            ->email('email', false, 'E-Mail must be valid')
            ->minLength('email', 3, 'Too short')
            ->maxLength('email', 60, 'Too long')
            ->requirePresence('password', 'This field is required')
            ->notEmptyString('password', 'Password is required')
            ->minLength('password', 3, 'Too short')
            ->maxLength('password', 60, 'Too long')
            ->requirePresence('first_name', 'This field is required')
            ->notEmptyString('first_name', 'Email is required')
            ->requirePresence('last_name', 'This field is required')
            ->notEmptyString('last_name', 'Email is required')
        ;
    }
}
