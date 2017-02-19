<?php
namespace App\View\Basic;

use App\View\AppView;

class BasicView extends AppView
{
/*
 *  App\View\BasicView::get()->render();
 */
    public function render()
    { ?>
<div><?=$this->data ?></div>
<?php
    }
}
