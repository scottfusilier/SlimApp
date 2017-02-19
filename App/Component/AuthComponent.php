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
    public function generateHash($value, $salt)
    {
        // This hashes the password with the salt so that it can be stored securely
        // in your database.  The output of this next statement is a 64 byte hex
        // string representing the 32 byte sha256 hash of the password.  The original
        // password cannot be recovered from the hash.  For more information:
        // http://en.wikipedia.org/wiki/Cryptographic_hash_function
        $hash = hash('sha256', $value.$salt);

        // Next we hash the hash value 65536 more times.  The purpose of this is to
        // protect against brute force attacks.  Now an attacker must compute the hash 65537
        // times for each guess they make against a password, whereas if the password
        // were hashed only once the attacker would have been able to make 65537 different
        // guesses in the same amount of time instead of only one.
        for ($round = 0; $round < 65536; $round++) {
            $hash = hash('sha256', $hash.$salt);
        }

        return $hash;
    }

    public function generateSalt()
    {
        // A salt is randomly generated here to protect again brute force attacks
        // and rainbow table attacks.  The following statement generates a hex
        // representation of an 8 byte salt.  Representing this in hex provides
        // no additional security, but makes it easier for humans to read.
        // For more information:
        // http://en.wikipedia.org/wiki/Salt_%28cryptography%29
        // http://en.wikipedia.org/wiki/Brute-force_attack
        // http://en.wikipedia.org/wiki/Rainbow_table
        return dechex(mt_rand(0, 2147483647)).dechex(mt_rand(0, 2147483647));
    }

/*
 * Register a new user
 */
    public function register($args = array())
    {
        if (empty($args)) {
            return false;
        }

        $salt = $this->generateSalt();
        $password = $this->generateHash($args['password'], $salt);

        $User = User::get();
        $User->UserEmail = $args['email'];
        $User->FirstName = $args['firstname'];
        $User->LastName = $args['lastname'];
        $User->Password = $password;
        $User->Salt = $salt;

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
            // Using the password submitted by the user and the salt stored in the database,
            // we now check to see whether the passwords match by hashing the submitted password
            // and comparing it to the hashed version already stored in the database.
            $check_password = $this->generateHash($args['password'],$User->Salt);

            if ($check_password === $User->Password) {
                $login_ok = true;
            }
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
