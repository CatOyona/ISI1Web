<?php
    declare(strict_types=1);
    session_start();
    require_once __DIR__ . '/fonctions.php';

    $messageConfirmation = $_SESSION['message'] ?? null;
    unset($_SESSION['message']);

    $erreurs = [];
    $nom = '';
    $email = '';
    $age = '';
    $filiere = '';
    $langages = [];
    $message = '';
    $reglement = false;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nom = champ('nom');
        $email = champ('email');
        $age = champ('age');
        $filiere = champ('filiere');
        $langages = champTab('langages');
        $message = champ('message');
        $reglement = champBool('reglement');

        $erreurs = array_filter([
            "nom" => validerNom($nom),
            "email" => validerEmail($email),
            "age" => validerAge($age),
            "filiere" => validerFiliere($filiere),
            "langages" => validerLangages($langages),
            "message" => validerMessage($message),
            "reglement" => validerReglement($reglement)
        ]);

        if ($erreurs === []) {
            $_SESSION['message'] = $nom.", votre inscription est réussie!";
            header('Location: inscription.php');
            exit;
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
                <label>Votre nom : *</label><br>
                <input name="nom" type="text" placeholder="Dupond" value = "<?= h($nom) ?>" required><br>
                <?php if (isset($erreurs['nom'])): ?>
                    <span class = "erreur" ><?= h($erreurs['nom']) ?></span>
                <?php endif; ?>
            </div>
    
            <div class = "entree_formulaire">
                <label>Votre email : *</label><br>
                <input name="email" type="email" placeholder="mail@fournisseur.com" value = "<?= h($email) ?>" required><br>
                <?php if (isset($erreurs['email'])): ?>
                    <span class = "erreur" ><?= h($erreurs['email']) ?></span>
                <?php endif; ?>
            </div>
            
            <div class = "entree_formulaire">
                <label>Votre âge :</label><br>
                <input name="age" type="number" placeholder="19" min="16" max="99" value = "<?= h($age) ?>"><br>
                <?php if (isset($erreurs['age'])): ?>
                    <span class = "erreur" ><?= h($erreurs['age']) ?></span>
                <?php endif; ?>
            </div>
            
            <div class = "entree_formulaire">
                <label>Filière :</label><br>
                <select name="filiere">
                    <option value="INFO" <?= $filiere === "INFO" ? "selected" : "" ?>>INFO</option>
                    <option value="MATH" <?= $filiere === "MATH" ? "selected" : "" ?>>MATH</option>
                    <option value="PHYS" <?= $filiere === "PHYS" ? "selected" : "" ?>>PHYS</option>
                    <option value="AUTRE" <?= $filiere === "AUTRE" ? "selected" : "" ?>>AUTRE</option>
                </select><br>
                <?php if (isset($erreurs['filiere'])): ?>
                    <span class = "erreur" ><?= h($erreurs['filiere']) ?></span>
                <?php endif; ?>
            </div>
            
            <div class = "entree_formulaire">
                <label>Vos langages :</label><br>
                <div>
                    <input type="checkbox" name="langages[]" value ="C++" <?= in_array("C++", $langages, true) ? 'checked' : "" ?>/>
                    <label>C++</label>
                </div>
                <div>
                    <input type="checkbox" name="langages[]" value = "Python" <?= in_array("Python", $langages, true) ? 'checked' : "" ?>/>
                    <label>Python</label>
                </div>
                <div>
                    <input type="checkbox" name="langages[]" value = "Java" <?= in_array("Java", $langages, true) ? 'checked' : "" ?>/>
                    <label>Java</label>
                </div>
                <div>
                    <input type="checkbox" name="langages[]" value = "PHP" <?= in_array("PHP", $langages, true) ? 'checked' : "" ?>/>
                    <label>PHP</label>
                </div>
                <?php if (isset($erreurs['langages'])): ?>
                    <span class = "erreur" ><?= h($erreurs['langages']) ?></span>
                <?php endif; ?>
            </div>
            
            <div class = "entree_formulaire">
                <label>Message ?</label><br>
                <textarea name="message" rows="5" cols="33" maxlength="300"><?= h($message) ?></textarea>
                <?php if (isset($erreurs['message'])): ?>
                    <span class = "erreur" ><?= h($erreurs['message']) ?></span>
                <?php endif; ?>
            </div>

            <div class = "entree_formulaire">
                <label>Accepter le règlement :</label><br>
                <div>
                    <input type="checkbox" name="reglement" <?= $reglement ? 'checked' : '' ?>/>
                    <label>J'accepte le règlement</label>
                </div>
                <?php if (isset($erreurs['reglement'])): ?>
                    <span class = "erreur" ><?= h($erreurs['reglement']) ?></span>
                <?php endif; ?>
            </div>
            
            <input class = "entree_formulaire" type="submit" value="Envoyer">
        </form>
    </fieldset>
    <?php if ($messageConfirmation !== null): ?>
        <h2 class = "confirmation"><?= h($messageConfirmation) ?></h2>
    <?php endif; ?>
    </body>
</html>