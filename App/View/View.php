<?php
namespace App\View;

abstract class View
{
    // basic data variable
    protected $data;

    // render data
    abstract public function render();

    // factory, example: Foo::get()->render();
    public static function get()
    {
        return new static();
    }

    // data variables setter, key => value
    public function setVars(array $vars = [])
    {
        foreach ($vars as $key => $value) {
            $this->{$key} = $value;
        }
        return $this; // chaining
    }
}
