<?php

namespace Dao;

use App\autoloader;
use Entity\User;

class UserDAO

{
    private $db;

    public function __construct()
    {
        $this->db = autoloader::$database;
    }

    public function create(User $user)
    {
        $query = $this->db->pdo->prepare("INSERT INTO users (firstname, lastname, email, password) 
            values (:firstname, :lastname, :email, :password)");

        $query->bindParam(':firstname', $user->getFirstname());
        $query->bindParam(':lastname', $user->getLastname());
        $query->bindParam(':email', $user->getEmail());
        $query->bindParam(':password', $user->getPassword());
        $query->execute();
        return true;
    }

    // login searchUser getUserByUserNameOrEmail getAllUser
    public function get(array $searchFields)
    {
        $insert = '';
        foreach ($searchFields as $key => $value) {
            $insert .= $key . ' = ' . '\'' . $value . '\'' . ' AND ';
        }
        $insert = substr($insert, 0, -5);
        $query = $this->db->pdo->prepare("SELECT * FROM users WHERE $insert");
        $query->execute();

        return $query->fetchAll();
    }

    public function getEmail($email)
    {
        $query = $this->db->pdo->prepare("SELECT email FROM users WHERE email = :email");
        $query->bindParam(':email', $email);
        $query->execute();

       return $query->fetchAll();
    }

}
