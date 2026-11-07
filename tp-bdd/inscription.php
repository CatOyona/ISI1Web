<?php
    declare(strict_types=1);
    session_start();
    require_once __DIR__ . '/fonctions.php';
    require_once __DIR__ . '/Database.php';
    require_once __DIR__ . '/Logger.php';
    require_once __DIR__ . '/SessionManager.php';

    $erreurs = [];
    $erreur = '';
    $nom = '';
    $password = '';
    $cpassword = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nom = champ('nom');
        $password = champMotDePasse('password');
        $cpassword = champMotDePasse('cpassword');

        $erreurs = array_filter([
            "nom" => validerNom($nom),
            "password" => validerPassword($password),
            "cpassword" => validerCPassword($password, $cpassword)
        ]);

        if ($erreurs === []) {
            $resultat = [];
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            try {
                $pdo = Database::getInstance()->getConnection();
                $stmt = $pdo->prepare('INSERT INTO users (username, password_hash) VALUES (:nom, :password_hash)');
                $stmt->execute(['nom' => $nom, 'password_hash' => $password_hash]);
            } catch (PDOException $e) {
                Logger::getInstance()->log($e->getMessage());
                if ($e->getCode() === '23000') {
                    $erreur = "Ce nom d'utilisateur est déjà pris";
                } else {
                    $erreur = 'Le service est momentanément indisponible.';
                }
            }
            if ($erreur === '') {
                Logger::getInstance()->log('Compté créé: '.$nom);
                SessionManager::getInstance()->setFlash('Compte créé: '.$nom);
                header('Location: index.php');
                exit;
            }
        }
    }
?>
<!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="styles.css" />
        <title>Inscription</title>
    </head>
    
    <body>
        <fieldset class = "formulaire">
        <legend>Formulaire d'inscription</legend>
        <form method = "POST">
            <div class = "entree_formulaire">
                <label>Nom d'utilisateur : *</label><br>
                <input name="nom" type="text" placeholder="JPdu42" value = "<?= h($nom) ?>" required><br>
                <?php if (isset($erreurs['nom'])): ?>
                    <span class = "erreur" ><?= h($erreurs['nom']) ?></span>
                <?php endif; ?>
            </div>
    
            <div class = "entree_formulaire">
                <label>Mot de passe : *</label><br>
                <input name="password" type="password" required><br>
                <?php if (isset($erreurs['password'])): ?>
                    <span class = "erreur" ><?= h($erreurs['password']) ?></span>
                <?php endif; ?>
            </div>
        
            <div class = "entree_formulaire">
                <label>Confirmer le mot de passe : *</label><br>
                <input name="cpassword" type="password" required><br>
                <?php if (isset($erreurs['cpassword'])): ?>
                    <span class = "erreur" ><?= h($erreurs['cpassword']) ?></span>
                <?php endif; ?>
            </div>
            
            <input class = "entree_formulaire" type="submit" value="Créer votre compte">
            <?php if ($erreur !== ''): ?>
                    <p class = "erreur" ><?= h($erreur) ?></p>
            <?php endif; ?>
        </form>
    </fieldset>
    </body>
</html>