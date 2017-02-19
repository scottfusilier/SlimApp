<?php
namespace App\View\System;

use App\View\AppView;

class AppError extends AppView
{
    public function render()
    { ?>
<div style="font-size: 32px; text-align: center; font-variant: small-caps;">Oops! This is not good...</div>
<?php
    }
}
