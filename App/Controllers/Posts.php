<?php


namespace Controllers;


use App\Auth\SessionAuth;
use Core\Controller;
use Dao\PostDao;
use Entity\Post;

class Posts extends Controller
{
    public function addNewPost()
    {
        $data = [
            'user_id' => SessionAuth::getUserId(),
            'body' => $_POST['body']
        ];
        $posts = new PostDao();
        $post = new Post($data);

        $createdPost = $posts->postPost($post);
        if ($createdPost) {
            header('Location: home');
            exit;
        }
    }


    public function deletePost(){
        (new PostDao())->deletePost($_GET['id']);
        header('Location: home');
    }
}