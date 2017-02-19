<?php
namespace App\Model\Auth;

use App\Model\AppModel;

/*
 * Store sessions in db
 */

class Session extends AppModel implements \SessionHandlerInterface
{
    protected function getIdField()
    {
        return 'idSession';
    }

    protected function createTable()
    {
        $className =  $this->getTableName();
        $sql = "CREATE TABLE IF NOT EXISTS `$className` (
        `".$this->getIdField()."` VARCHAR(32) NOT NULL,
        `access` INT(10) UNSIGNED DEFAULT NULL,
        `data` TEXT,
        PRIMARY KEY (`".$this->getIdField()."`)
        ) ENGINE=InnoDB";
        $this->execute($sql);
    }

/*
 * Open
 */
    public function open($savePath, $sessionName)
    {
        // If connection
        if ($this->getReadPdo()) {
            return true;
        }
        return false;
    }

/*
 * Close
 */
    public function close()
    {
        // Close the database connection
        return true;
    }

/*
 * Read
 */
    public function read($id)
    {
        if ($this->fetchObject($id)) {
            return $this->data;
        } else {
            return '';
        }
    }

/*
 * Write
 */
    public function write($id, $data)
    {
        // Create time stamp
        $access = time();

        $sql = 'INSERT INTO Session VALUES (:id, :access, :data) ON DUPLICATE KEY UPDATE access = :access, data = :data';

        if($this->writeQuery($sql,[':id' => $id, ':access' => $access, ':data' => $data])){
            return true;
        }
        return false;
    }

/*
 * Destroy
 */
    public function destroy($id = '')
    {
        if (!empty($id) && $this->fetchObject($id)) {
            return ($this->delete());
        }

        return ($this->delete());
    }

/*
 * Garbage Collection
 */
    public function gc($max)
    {
        // Calculate what is to be deemed old
        $old = time() - $max;

        $sql = 'DELETE * FROM Session WHERE access < :old';

        if ($this->writeQuery($sql,[':old' => $old])) {
            return true;
        }
        return false;
    }
}
