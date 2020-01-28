<?php

namespace Core;

use App\Users\Model;
use App\Users\User;

Class Session
{

    /** @var \App\Users\Model */
    private $model;

    private $user;
    /** @var \App\Users\Model */

    // object for logged in user
    public function __construct()
    {
        $this->loginFromCookie();
    }

    //
    public function loginFromCookie()
    {
        if (!empty($_SESSION)) {
            $this->login($_SESSION['email'], $_SESSION['password']);
        }
    }

    //
    public function login($email, $password)
    {
        $model = new \App\Users\Model();
        $users = $model->get([
            'email' => $email,
            'password' => $password,
        ]);

        if (!empty($users)) {
//            $_SESSION['email'] = $users[0]->getEmail();
//            $_SESSION['password'] = $users[0]->getPassword();
            // Gets replaced by below code:
            $_SESSION['email'] = $email;
            $_SESSION['password'] = $password;
            $this->user = $users[0];

            return true;
        }

        return false;

    }

    // returns logged in user object
    public function getUser($conditions)
    {
        return $this->user;
    }

    // returns true or false if user is logged in
    public function userLoggedIn()
    {
        if($this->user)
        {
            return true;
        }
        return false;
    }

    //
    public function logout($redirect)
    {
        $_SESSION = [];
        session_destroy();
        setcookie(session_name(), null, -1);
        if ($redirect) {
            header("Location: $redirect");
        }
    }

}
