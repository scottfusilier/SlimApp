<?php
namespace App\Template;

use App\View\View;

abstract class AppTemplate
{
    public static function get()
    {
        return new static();
    }

    public abstract function render(View $content);
}
