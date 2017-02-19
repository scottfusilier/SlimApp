<?php
namespace App\Model\Auth;

use App\Model\AppModel;

class PermGroupToObject extends AppModel
{
    protected function getIdField()
    {
        return 'idPermGroupToObject';
    }

    protected function createTable()
    {
        $className = $this->getTableName();
        $sql = "CREATE TABLE IF NOT EXISTS `$className` (
              `".$this->getIdField()."` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
              `idPermGroup` INT(10) UNSIGNED NOT NULL,
              `idObject` INT(10) UNSIGNED NOT NULL,
              `idPermission` INT(10) UNSIGNED NOT NULL,
              PRIMARY KEY (`".$this->getIdField()."`)
            ) ENGINE=InnoDB AUTO_INCREMENT=1024171332";
        $this->execute($sql);
    }
}
