<?php
namespace App\Helper;

class CSRF
{
    public static function getCSRFToken($uniqueFormName) {
        $nonce = base64_encode(openssl_random_pseudo_bytes(32));
        if (empty($_SESSION['csrf_tokens'])) {
            $_SESSION['csrf_tokens'] = array();
        }
        $_SESSION['csrf_tokens'][$uniqueFormName] = $nonce;
        return $nonce;
    }

    public static function  validateCSRFToken($uniqueFormName,$token) {
        if (isset($_SESSION['csrf_tokens'][$uniqueFormName])) {
            if ($_SESSION['csrf_tokens'][$uniqueFormName] === $token) {
                unset($_SESSION['csrf_tokens'][$uniqueFormName]);
                return true;
            }
        }
        return false;
    }
/*
 * usage:
 *
 *
//Render Form
$formName = 'login';
$token = Core\Helper\CSRF::getCSRFToken($formName);
echo '<input type="hidden" name="csrf_token" value="' . $token . '"/>'
echo '<input type="hidden" name="csrf_formname" value="' . $formName. '"/>'

//Validate Form
$formName = isset($_POST['formName']) ? $_POST['formName'] : '';
$token = isset($_POST['csrf_token']) ? $_POST['csrf_token'] : '';
$valid = !empty($token) && Core\Helper\CSRF::validateCSRFToken($formName, $token);
if (!$valid) {
    // Attack Detected! Fail!
}*/
}
