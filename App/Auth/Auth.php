<?php


namespace App\Auth;


interface Auth
{
    public static function logIn($user);

    public static function logOut();

    public static function isLoggedIn();
}