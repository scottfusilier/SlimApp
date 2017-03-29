<?php

namespace App\Component;

use App\Model\Auth\Permission;
use App\Model\Auth\User;
use App\Helper\CSRF;

class AuthComponent extends Component
{
    private $User;

    public function __construct()
    {
        $this->initUser();
    }

/*
 * Initialize User if exists
 */
    public function initUser()
    {
        if ($this->sessionHasVar('user')) {
            $this->User = $this->sessionGetVar('user');
        } else {
            $this->User = array();
        }
    }

/*
 * Determine if user is currently logged in
 */
    public function hasUser()
    {
        if (!empty($this->User)) {
            return true;
        } else {
            return false;
        }
    }

/*
 * User accessor
 */
    public function getUser()
    {
        return $this->User;
    }

/*
 * User id field accessor
 */
    public function getUserID()
    {
        return $this->User['idUser'];
    }

/*
 * Session var setter
 */
    public function sessionSetVar($key,$value)
    {
        $_SESSION[$key] = $value;
    }

/*
 * Session has var
 */
    public function sessionHasVar($key)
    {
        if (!empty($_SESSION[$key])) {
            return true;
        }
        return false;
    }

/*
 * Session var accessor
 */
    public function sessionGetVar($key)
    {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }
        return false;
    }

/*
 * Session var unsetter
 */
    public function sessionRemoveVar($key)
    {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
            return true;
        }
        return false;
    }

/*
 * Wrapper function for Permissions::isAuthorized
 *
 */
    public function userAuthorized($objectName, $permission = 'Read')
    {
        if (empty($this->User)) {
            return false;
        }
        return (Permission::get()->isAuthorized($this->User['idUser'], $objectName, $permission));
    }

/*
 * Remove a user
 */
    public function removeUser($idUser = 0)
    {
        return User::get()->delete($idUser);
    }

/*
 * Hash a field
 */
    public function generateHash($value)
    {
        $options = [
            'cost' => 12
        ];

        return password_hash($value, PASSWORD_BCRYPT, $options);
    }

    public function generateSalt()
    {
        // do not use, allow password_hash to create salt
        return null;
    }

/*
 * Register a new user
 */
    public function register($args = array())
    {
        if (empty($args)) {
            return false;
        }

        $password = $this->generateHash($args['password']);
        if (!$password) {
            throw new \Exception('password failure');
        }

        $User = User::get();
        $User->UserEmail = $args['email'];
        $User->FirstName = $args['firstname'];
        $User->LastName = $args['lastname'];
        $User->Password = $password;

        return $User->save();
    }

/*
 * Log user in
 */
    public function login($args = array())
    {
        if (empty($args)) {
            return false;
        }

        //check csrf token
        $token = $args['token'];
        $formName = $args['formName'];
        if (!CSRF::validateCSRFToken($formName,$token)) {
            return false;
        }

        $login_ok = false;
        // get user from User data Model
        $User = User::get()->fetchByField('UserEmail', $args['email']);
        if ($User) {
            $login_ok = password_verify($args['password'],$User->Password);
        }

        if ($login_ok) {
            $user = [
                'idUser' => $User->idUser,
                'FirstName' => $User->FirstName,
                'LastName' => $User->LastName,
            ];
            // store the user's data into the session
            $this->sessionSetVar('user',$user);
            $this->User = $user;
            //success
            return true;
        } else {
            return false;
        }
    }

/*
 * Log user out
 */
    public function logout()
    {
        $this->sessionRemoveVar('user');
        $this->User = array();
        session_destroy();
    }
}
