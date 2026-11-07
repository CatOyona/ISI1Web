<?php
    declare(strict_types=1);
    require_once __DIR__ . '/SessionManager.php';
    require_once __DIR__ . '/Logger.php';

    $session = SessionManager::getInstance();
    Logger::getInstance()->log($session->get('username')." s'est déconnecté(e).");
    $session->detruire();
    header('Location: index.php');
    exit;