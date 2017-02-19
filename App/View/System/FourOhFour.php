<?php
namespace App\View\System;

use App\View\AppView;

class FourOhFour extends AppView
{
    public function render()
    { ?>
<div style="font-size: 400px; text-align: center;">404</div>
<div style="font-size: 128px; text-align: center; font-variant: small-caps;">Not Found</div>
<div style="text-align: center;">The document you requested could not be found.</div>
<?php
    }
}
