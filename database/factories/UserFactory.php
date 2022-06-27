<?php

Factory :: define(\App\Models\User :: class, function ($faker) {
    return [
        'first_name'=>$faker->firstName,
        'last_name'=>$faker->lastName,
        'email'=>   $faker->unique()->email,
        'password'=> password_hash('secret',PASSWORD_BCRYPT),
        'created_at'=>date('Y-m-dH:i:s'),
        'updated_at'=>date('Y-m-dH:i:s'),
    ];
});
