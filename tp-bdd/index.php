<?php
    declare(strict_types=1);
    require_once __DIR__ . '/fonctions.php';
    require_once __DIR__ . '/Database.php';
    require_once __DIR__ . '/Logger.php';
    require_once __DIR__ . '/SessionManager.php';
    require_once __DIR__ . '/Utilisateur.php';

    $session = SessionManager::getInstance();
    if ($session->has('user_id')) {
        header('Location: dashboard.php');
        exit;
    }

    $erreur = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = champ('username');
        $password = champMotDePasse('password');
        $resultat = [];
        try {
            $pdo = Database::getInstance()->getConnection();
            $stmt = $pdo->prepare('SELECT id, username, password_hash, role FROM users WHERE username = :nom');
            $stmt->execute(['nom' => $username]);
            $resultat = $stmt->fetch();
        } catch (PDOException $e) {
            Logger::getInstance()->log($e->getMessage());
            $erreur = 'Le service est momentanément indisponible.';
        }

        if ($erreur === '' && $resultat !== false && password_verify($password, $resultat['password_hash'])) {
            $session->regenerer();
            $session->set('user_id', $resultat['id']);
            $session->set('username', $resultat['username']);
            $user = Utilisateur::depuisLigne($resultat);
            $session->set('role', $user->role->value);
            Logger::getInstance()->log($resultat['username']." s'est connecté(e).");
            header('Location: dashboard.php');
            exit;
        } else {
            if ($erreur === '') {
                $erreur = 'Identifiants invalides.';
                Logger::getInstance()->log('Tentative de connexion infructueuse.');
            }
        }
    }

    $flash = $session->popFlash();
    if ($flash !== null) {
        $erreur = $flash;
    }
?>
<!DOCTYPE html>
<html lang="fr">
    <head><meta charset="utf-8"><title>Connexion</title></head>
    <body>
        <h1>Connexion:</h1>
        <form method="POST">
            <input type="text" name="username" placeholder="Nom d'utilisateur">
            <input type="password" name="password" placeholder="Mot de passe">
            <button type="submit">Se connecter</button>
        </form>
        <p><?= h($erreur) ?></p>
        <a href = "inscription.php">S'inscrire</a>
    </body>
</html>