<?php

namespace Controllers;

use App\Auth\SessionAuth;
use App\helpers\ValidationHandler;
use \Core\Controller;
use Dao\UserDAO;
use Dao\PostDao;
use Entity\Post;
use Entity\User;


class Users extends Controller
{
    public function sign()
    {
        if (SessionAuth::isLoggedIn()) {
            header("Location: http://{$_SERVER['HTTP_HOST']}/home");
        } else {
            $this->render('sign', ['title' => 'Welcome ']);
        }
    }

    public function login()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $user = ['email' => $_POST['email'],
                'password' => $_POST['password']];

            $dataErrors = [
                'emailError' => '',
                'passwordError' => ''
            ];

            if (ValidationHandler::validationEmail($user['email'], $dataErrors['emailError'])
                && ValidationHandler::validationPassword($user['password'], $dataErrors['passwordError'])) {
                $user['password'] = md5($user['password']);
                $dao = new UserDAO();
                $dbResult = $dao->get($user);

                if (!empty($dbResult)) {
                    SessionAuth::logIn($dbResult[0]['id']);
                    header("Location: home");
                } else {
                    $dataErrors['passwordError'] = 'This email or password is invalid';
                    $this->render('login', ['title' => 'Login ', 'email' => $user['email'], 'dataErrors' => $dataErrors]);
                }
            }else {
                $this->render('login', ['title' => 'Login ', 'data' => $user, 'dataErrors' => $dataErrors]);
            }
        } else {
            if (!SessionAuth::isLoggedIn()) {
                $this->render('login', ['title' => 'Login ']);
            } else {
                header("Location: home");
            }
        }
    }

    public function signup()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $data = [
                'firstname' => $_POST['firstName'],
                'lastname' => $_POST['lastName'],
                'email' => $_POST['email'],
                'password' => $_POST['password'],
                'confirmPassword' => $_POST['confirmPassword']
            ];

            $dataErrors = [
                'errorFirstName' => '',
                'errorLastName' => '',
                'errorEmail' => '',
                'errorPassword' => '',
                'errorConfirmPassword' => ''
            ];
            $userDAO=new UserDAO();
            $checkExisting = $userDAO->getEmail($data['email']);
            if($checkExisting){
                $dataErrors['errorEmail']='This email already exist';
            }
            if (ValidationHandler::validationFields($data, $dataErrors) && !$checkExisting) {

                $data['password'] = md5($data['password']);

                $user = new User($data);

                $userDao = new UserDAO();
                $createdUser = $userDao->create($user);

                if ($createdUser) {
                    $dbResult = $userDao->get(['email' => $data['email'], 'password' => $data['password']]);
                    SessionAuth::logIn($dbResult[0]['id']);
                    header("Location: home");
                    exit;
                }
            } else {
                $this->render('signup', ['title' => 'Signup ', 'data' => $data, 'dataErrors' => $dataErrors]);
            }
        } else {
            if (!SessionAuth::isLoggedIn()) {
                $this->render('signup', ['title' => 'Signup ']);
            } else {
                $id = SessionAuth::getUserId();
                header("Location: home");
            }
        }
    }

    public function home()
    {

        if (SessionAuth::isLoggedIn()) {
            $dao = new UserDAO();
            $dbResult = $dao->get(['id' => SessionAuth::getUserId()]);
            $posts = new PostDao;
            $this->render('home', [
                'title' => 'Home ',
                'arr' => $posts->getAllPosts(),
                'user' => $dbResult[0],
                'id' => SessionAuth::getUserId(),]);
        } else {
            header("Location: http://{$_SERVER['HTTP_HOST']}/");
            exit;
        }
    }

    public function logOut()
    {
        SessionAuth::logOut();
        header("Location: http://{$_SERVER['HTTP_HOST']}/");
    }

}
