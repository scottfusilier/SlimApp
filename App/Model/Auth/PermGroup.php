<?php
namespace App\Model\Auth;

use App\Model\AppModel;

class PermGroup extends AppModel
{
    protected function getIdField()
    {
        return 'idPermGroup';
    }

    protected function createTable()
    {
        $className = $this->getTableName();
        $sql = "CREATE TABLE IF NOT EXISTS `$className` (
              `".$this->getIdField()."` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
              `GroupName` VARCHAR(255) NOT NULL UNIQUE,
              `Valid` TINYINT NOT NULL DEFAULT 1,
              PRIMARY KEY (`".$this->getIdField()."`)
            ) ENGINE=InnoDB AUTO_INCREMENT=1124478911";
        $this->execute($sql);
    }
}
