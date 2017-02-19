<?php
/*
 * config params here
 */

// Register database configuration callables. Callable should return a new connection object.
// NOTE: ConnectionContainer will call the Callable on first access and then return the same connection instance on every subsequent access.

Data\Container\ConnectionContainer::register('default',
function () {
    try {
        $obj = new \PDO('mysql:host=172.16.1.17;dbname=Example_DB;charset=utf8','ExampleUser','ExamplePass',[]);
    } catch (\PDOException $e) {
        die('Connection Error');
    }
    return $obj;
});

/*
Lib\Container\ConnectionContainer::register('another-connection',
function () {
    try {
        $obj = new \PDO('mysql:host=localhost;dbname=Example_Database;charset=utf8','ExampleUser','ExamplePass',[]);
    } catch (\PDOException $e) {
        die('Connection Error');
    }
    return $obj;
});
*/

// set default timezone
date_default_timezone_set('America/New_York');

// initialize database session handler
//$handler = App\Model\Auth\Session::get();
//session_set_save_handler($handler, true);
