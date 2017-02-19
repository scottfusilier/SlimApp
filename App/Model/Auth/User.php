<?php
namespace App\Model\Auth;

use App\Model\AppModel;

class User extends AppModel
{
    protected function getIdField()
    {
        return 'idUser';
    }

    protected function createTable()
    {
        $className = $this->getTableName();
        $sql = 'CREATE TABLE IF NOT EXISTS `'.$className.'` (
              `'.$this->getIdField().'` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
              `UserEmail` VARCHAR(255) NOT NULL,
              `FirstName` VARCHAR(255) NOT NULL,
              `LastName` VARCHAR(255) NOT NULL,
              `Password` CHAR(64) NOT NULL,
              `Salt` CHAR(16) NOT NULL,
              PRIMARY KEY (`'.$this->getIdField().'`),
              UNIQUE KEY `UserEmail` (`UserEmail`)
          ) ENGINE=InnoDB AUTO_INCREMENT=1263945395';
        $this->execute($sql);
    }
}
