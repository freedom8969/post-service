<?php


namespace App\helpers;


use Dao\UserDAO;

class ValidationHandler
{
    public static function validationFLName(string $flname, string &$error)
    {
        if (!empty($flname)) {
            $regEx = "/^[A-Za-z]{3,30}$/";

            if (preg_match($regEx, $flname)) {
                return true;
            } else {
                $error = 'Incorrect Name';
                return false;
            }
        }else{
            $error = 'fill in the field.';
            return false;
        }
    }

    public static function validationEmail(string $email, string &$error)
    {
        if (!empty($email)) {
            $regEx = "/^\w+@\w+\.\w{2,}$/";

            if (preg_match($regEx, $email)) {
                return true;
            } else {
                $error = 'Incorrect email';
                return false;
            }
        }else{
            $error = 'fill in the field.';
            return false;
        }

    }



    public static function validationPassword($password, &$error)
    {
        if (!empty($password)) {
            $rexEx = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.{6,})/";

            if (preg_match($rexEx, $password)) {
                return true;
            } else {
                $error = 'Password must be at least six(6) characters long and must can contain one uppercase letter and number.';
                return false;
            }
        }
        else{
            $error = 'fill in the field.';
            return false;
        }
    }

    public static function validationConfirmPassword(string $password, string $confirmPassword, string &$error)
    {
        if (!empty($password) && !empty($confirmPassword)) {
            if (trim($password) == trim($confirmPassword)) {
                return true;
            } else {
                $error = 'Password must be the same';
                return false;
            }
        }
        else{
            $error = 'fill in the field.';
            return false;
        }
    }


    public static function validationFields(array $data, array &$dataErrors)
    {
        return self::validationFLName($data['firstname'], $dataErrors['errorFirstName'])
            & self::validationFLName($data['lastname'], $dataErrors['errorLastName'])
            & self::validationEmail($data['email'], $dataErrors['errorEmail'])
            & self::validationPassword($data['password'], $dataErrors['errorPassword'])
            & self::validationConfirmPassword($data['password'], $data['confirmPassword'], $dataErrors['errorConfirmPassword']);
    }



}