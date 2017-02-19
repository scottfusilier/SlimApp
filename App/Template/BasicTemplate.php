<?php
namespace App\Template;

use App\View\View;
use App\View\Basic\BasicHeaderView as Header;
use App\View\Basic\BasicFooterView as Footer;

class BasicTemplate extends AppTemplate
{
    public function render(View $content)
    {
        // site header
        Header::get()->render();
        // site content
        $content->render();
        // site footer
        Footer::get()->render();
    }
}
