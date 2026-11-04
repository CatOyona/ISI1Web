<?php
    require_once __DIR__ . '/Database.php';
    require_once __DIR__ . '/Logger.php';

    $a = Database::getInstance()->getConnection();
    $b = Database::getInstance()->getConnection();
    var_dump($a === $b);

    try {
        $d = new Database();
    } catch (Error $e) {
        print($e);
    }

    try {
        $copie = clone $a;
    } catch (Error $e) {
        print($e);
    }
    
    try {
        $l = Logger::getInstance();
        $ser = serialize($l);
        $des = unserialize($l);
    } catch (Error $e) {
        print($e);
    }
?>