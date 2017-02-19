<?php
namespace App\View\User;
use App\View\AppView as View;
use App\Helper\CSRF;

class Login extends View
{
    protected $errorMsg = '';

    public function render()
    {
        $formName = 'login';
        $token = CSRF::getCSRFToken($formName);
?>
<style>
.login-container {
    max-width: 330px;
    margin: 0 auto;
}
.login-input {
    margin-top: 5px;
}
</style>
<div class="container">
    <div class="login-container">
        <h1>Please sign in</h1>
        <?=$this->errorMsg."\n" ?>
        <div>
            <form action="/login" method="post">
                <div class="login-input">
                    <input class="form-control" type="text" name="email" value="" alt="Email" placeholder="Email" tabindex=1 />
                </div>
                <div class="login-input">
                    <input class="form-control" type="password" name="password" value="" alt="Password" placeholder="Password" tabindex=2 />
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" value="remember-me"> Remember me
                    </label>
                </div>
                <div class="login-input">
                    <button class="btn btn-lg btn-primary btn-block" type="submit" tabindex=3 >Sign in</button>
                    <input type="hidden" name="token" value="<?=$token ?>"/>
                    <input type="hidden" name="formName" value="<?=$formName ?>"/>
                </div>
            </form>
        </div>
    </div>
</div>
<?php
    }
}
