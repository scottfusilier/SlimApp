<?php
namespace App\Model\Auth;

use App\Model\AppModel;

class UserToPermGroup extends AppModel
{
    protected function getIdField()
    {
        return 'idUserToPermGroup';
    }

    protected function createTable()
    {
        $className = $this->getTableName();
        $sql = "CREATE TABLE IF NOT EXISTS `$className` (
              `".$this->getIdField()."` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
              `idUser` INT(10) UNSIGNED NOT NULL, 
              `idPermGroup` INT(10) UNSIGNED NOT NULL, 
              PRIMARY KEY (`".$this->getIdField()."`)
            ) ENGINE=InnoDB AUTO_INCREMENT=1134471211";
        $this->execute($sql);
    }
}
