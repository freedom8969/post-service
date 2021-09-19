<?php


namespace Entity;


class Post
{
    private $user_id;
    private $body;

    public function __construct(array $arrayPost)
    {
        $this->user_id = $arrayPost['user_id'];
        $this->body = $arrayPost['body'];
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param mixed $user_id
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    /**
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param mixed $body
     */
    public function setBody($body)
    {
        $this->body = $body;
    }



}