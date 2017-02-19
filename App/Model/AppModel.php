<?php
namespace App\Model;

use Data\Model\SqlModel;

abstract class AppModel extends SqlModel
{
    public function setup()
    {
        return $this->createTable();
    }
}
