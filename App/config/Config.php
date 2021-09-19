<?php


namespace App\config;


class Config
{
    public const ROUTS = [
        '/' => 'Users@sign',
        '/login' => 'Users@login',
        '/signup' => 'Users@signup',
        '/home' => 'Users@home',
        '/logOut' => 'Users@logOut',

        '/Post' => 'Posts@AddNewPost',
        '/delPost' => 'Posts@deletePost',

    ];
}
