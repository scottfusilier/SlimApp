<?php
namespace App\Model;

use Data\Model\MySqlModel;

abstract class AppModel extends MySqlModel
{
    public function setup()
    {
        return $this->createTable();
    }
}
