<?php
    declare(strict_types=1);
    require_once __DIR__ . '/fonctions.php';
    require_once __DIR__ . '/Database.php';
    require_once __DIR__ . '/Logger.php';
    require_once __DIR__ . '/SessionManager.php';

    $session = SessionManager::getInstance();
    if ($session->has('user_id')) {
        header('Location: dashboard.php');
        exit;
    }

    $username = champ('username');
    $password = champMotDePasse('password');

    $resultat = [];
    $erreur = '';
    $sql = "SELECT id, username, created_at FROM users ORDER BY username";
    try {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->prepare('SELECT id, username, password_hash FROM users WHERE username = :nom');
        $stmt->execute(['nom' => $username]);
        $resultat = $stmt->fetchAll();
    } catch (PDOException $e) {
        Logger::getInstance()->log($e->getMessage());
        $erreur = 'Le service est momentanément indisponible.';
    }

    if ($erreur ===! '' && $resultat ===! [] && password_verify($password, $resultat['password_hash'])) {
        $session->regenerer();
        $session->set('user_id', $resultat['id']);
        $session->set('username', $resultat['username']);
        Logger::getInstance()->log('('.$resultat['id'].') '.$resultat['username']."s'est connecté.");
        header('Location: dashboard.php');
        exit;
    } else {
        $erreur = 'Indentifiants invalides.';
        Logger::getInstance()->log('Tentative de connexion infructueuse.');
    }

    if ($session->popFlash() ===! null) {
        $erreur = $session->popFlash();
    }
?>
<!DOCTYPE html>
<html lang="fr">
    <head><meta charset="utf-8"><title>Recherche (version vulnérable)</title></head>
    <body>
        <h1>Connexion:</h1>
        <form method="POST">
            <input type="text" name="username" placeholder="Nom d'utilisateur">
            <input type="password" placeholder="Mot de passe">
            <button type="submit">Se connecter</button>
        </form>
        <p><?= h($erreur) ?></p>
    </body>
</html>