<?php
    require_once __DIR__ . '/SessionManager.php';
    require_once __DIR__ . '/fonctions.php';
    require_once __DIR__ . '/Logger.php';
    

    $session = SessionManager::getInstance();
    $role = $session->get('role');
    if (!$session->has('user_id')) {
        header('Location: index.php');
        exit;
    }
    Logger::getInstance()->log($session->get('username')." a accédé au dashboard.");
?>
<!DOCTYPE html>
<html lang="fr">
    <head><meta charset="utf-8"><title>Dashboard</title></head>
    <body>
        <h1>Bienvenue, <?= h($session->get("username"))?></h1>
        <p>Votre rôle: <?= $role ?></p>
        <?php if ($role === 'admin'): ?>
            <a href = "admin.php">Page réservée aux admins</a>
        <?php endif; ?>
        <a href = "logout.php">Se déconnecter</a>
    </body>
</html>