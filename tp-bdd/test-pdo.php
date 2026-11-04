<?php
    declare(strict_types=1);
    require_once __DIR__ . '/fonctions.php';
    require_once __DIR__ . '/Database.php';
    require_once __DIR__ . '/Logger.php';
    $utilisateurs = [];
    $erreur = '';
    $sql = "SELECT id, username, created_at FROM users ORDER BY username";
    try {
        $pdo = Database::getInstance()->getConnection();
        $utilisateurs = $pdo->query($sql)->fetchAll();
    } catch (PDOException $e) {
        Logger::getInstance()->log($e->getMessage());
        $erreur = 'Le service est momentanément indisponible.';
    }
?>
<!DOCTYPE html>
<html lang="fr">
    <head><meta charset="utf-8"><title>Recherche (version vulnérable)</title></head>
    <body>
        <h1>Les utilisateurs:</h1>
        <?php
            if (!($erreur === '')) {
                    echo $erreur;
                }
        ?>
        <ul>
            <?php
                if ($erreur === '') {
                    foreach ($utilisateurs as $u) {
                        echo '<li>'.h($u['username']) . '</li>';
                    }
                }
            ?>
        </ul>
    </body>
</html>