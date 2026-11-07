<?php
    require_once __DIR__ . '/SessionManager.php';
    require_once __DIR__ . '/fonctions.php';
    require_once __DIR__ . '/Database.php';
    require_once __DIR__ . '/Logger.php';
    

    $session = SessionManager::getInstance();
    $role = $session->get('role');
    $erreur = '';
    $resultat = [];
    if (!$session->has('user_id')) {
        header('Location: index.php');
        exit;
    }
    if ($role !== 'admin') {
        Logger::getInstance()->log($session->get('username')." a éssayé d'accéder à la page admin.");
        http_response_code(403);
        exit;
    } else {
        Logger::getInstance()->log($session->get('username')." a accédé à la page admin.");
        try {
            $pdo = Database::getInstance()->getConnection();
            $resultat = $pdo->query('SELECT id, username, created_at, role FROM users');
        } catch (PDOException $e) {
            Logger::getInstance()->log($e->getMessage());
            $erreur = 'Le service est momentanément indisponible.';
        }
    }
?>
<!DOCTYPE html>
<html lang="fr">
    <head><meta charset="utf-8"><title>Dashboard</title></head>
    <style>
        table, th, td {
            border:1px solid black;
        }
    </style>
    <body>
        <?php if ($role === 'admin' && $resultat !== []): ?>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Rôle</th>
                    <th>Date d'inscription</th>
                </tr>
                <?php foreach ($resultat as $r): ?>
                    <tr>
                        <td><?= h($r['id']) ?></td>
                        <td><?= h($r['username']) ?></td>
                        <td><?= h($r['role']) ?></td>
                        <td><?= h($r['created_at']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
            <p><?= h($erreur) ?></p>
        <?php endif; ?>
    </body>
</html>