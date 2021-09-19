<?php


namespace Controllers;


use Core\Controller;

class Error extends Controller
{
    public function error404 ()
    {
        $this->render('error404',['title'=>'404 ']);
    }

}