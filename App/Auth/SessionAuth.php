<?php


namespace App\Auth;

use Dao\UserDAO;
use Entity\User;

session_start();
class SessionAuth implements Auth
{

    public static function init(){
        if(!isset($_COOKIE["currentUserId"]) || $_COOKIE["currentUserId"] == '-1'){
            setcookie("currentUserId", '-1', 0, '/');
            $_SESSION['loggedIn'] = false;
            $_SESSION['currentUserId'] = -1;
        }else if($_COOKIE['currentUserId']!= '-1'){
            $_SESSION['loggedIn'] = true;
            $_SESSION['currentUserId'] = $_COOKIE['currentUserId'];
        }
    }

    public static function logIn($user)
    {
        $_SESSION['loggedIn'] = true;
        $_SESSION['currentUserId'] = $user;
        setcookie('currentUserId', strval($user), time()+1800, '/');
    }

    public static function logOut()
    {
        setcookie("currentUserId", '-1', 0, '/');
        $_SESSION['loggedIn'] = false;
        $_SESSION['currentUserId'] = -1;
    }


    public static function isLoggedIn()
    {
        //(!isset($_COOKIE['currentUserId']) || $_COOKIE['currentUserId'] == '-1') ||
        if($_SESSION['loggedIn'] == false){
            return false;
        }else{
            return true;
        }
    }

    public static function getUserId(){
        return $_SESSION['currentUserId'];
    }
}