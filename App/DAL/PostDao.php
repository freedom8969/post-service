<?php

namespace Dao;

use App\autoloader;
use Entity\Post;

class PostDao
{
    private $db;

    public function __construct()
    {
        $this->db = autoloader::$database;
    }

    public function getAllPosts()
    {
        $query = $this->db->pdo->prepare("
             SELECT 
                posts.id, firstname, lastname, userId, posts.created_at, body
             FROM   
                posts  
             LEFT JOIN 
                users
             ON 
                posts.userId=users.id 
             ORDER BY 
                posts.created_at DESC");
        $query->execute();
        return $query->fetchAll();
    }


    public function postPost(Post $post)
    {
        $query = $this->db->pdo->prepare("
            INSERT INTO 
                posts 
                (userId, body) 
            values 
                (:user_id, :body)");
        $query->bindParam(':user_id', $post->getUserId());
        $query->bindParam(':body', $post->getBody());
        $query->execute();
        return true;
    }


    public function deletePost($id)
    {
        $query = $this->db->pdo->prepare("
            DELETE FROM posts
            WHERE id=$id");
        $query->execute();
    }

}
