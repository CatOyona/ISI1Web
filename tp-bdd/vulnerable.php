<?php
    declare(strict_types=1);
    require_once __DIR__ . '/fonctions.php';
    $pdo = new PDO(
        'mysql:host=localhost;dbname=app_db;charset=utf8mb4',
        'app_user',
        'app_password',
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE =>
        PDO::FETCH_ASSOC]
    );
    $nom = $_GET['nom'] ?? '';
    $nom = is_string($nom) ? $nom : '';
    $sql = '';
    $resultats = [];
    if ($nom !== '') {
        $stmt = $pdo->prepare('SELECT id, username FROM users WHERE username = :nom');
        $stmt->execute(['nom' => $nom]);
        $resultats = $stmt->fetchAll();
    }
?>
<!DOCTYPE html>
<html lang="fr">
    <head><meta charset="utf-8"><title>Recherche (version vulnérable)</title></head>
    <body>
        <h1>Rechercher un utilisateur</h1>
        <form method="get">
            <input type="text" name="nom" value="<?= h($nom) ?>">
            <button type="submit">Chercher</button>
        </form>
        <?php if ($stmt->queryString !== ''): ?>
        <p>Requête exécutée : <code><?= h($stmt->queryString) ?></code></p>
        <ul>
            <?php foreach ($resultats as $r): ?>
            <li><?= h($r['username']) ?></li>
            <?php endforeach; ?>
        </ul>
        <?php endif; ?>
    </body>
</html>