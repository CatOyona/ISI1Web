<?php
    declare(strict_types=1);
    require_once __DIR__ . '/fonctions.php';
    $erreurs = [];

    $nom = '';
    $email = '';
    $age = 0;
    $filiere = '';
    $langages = [];
    $message = '';
    $reglement = false;

    enum Langage: string {
        case Cpp = 'C++';
        case PYTHON = 'Python';
        case JAVA = 'Java';
        case PHP = 'PHP';
    }

    enum Filiere: string {
        case INFO = 'INFO';
        case MATH = 'MATH';
        case PHYS = 'PHYS';
        case AUTRE = 'AUTRE';
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nom = champ('nom');
        $email = champ('email');
        $age = (int) champ('age');
        $filiere = champ('filiere');
        $langages = champTab('langages');
        $message = champ('message');
        $reglement = champBool('reglement');

        //Nom obligatoire et entre 2 et 50 caracs
        if ($nom === '') {
            $erreurs['nom'] = "Le nom est obligatoire";
        } elseif (mb_strlen($nom) > 50 || mb_strlen($nom) < 2) {
            $erreurs['nom'] = "Le nom doit être compris entre 2 et 50 caractères.";
        }

        //Email au fomat valide et obligatoire
        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            $erreurs['email'] = 'Adresse mail invalide.';
        }

        //Âge entre 16 et 99
        if ($age !== 0 && ($age < 16 || $age > 99)) {
            $erreurs['age'] = "Âge compris entre 16 et 99.";
        }

        //Filière avec valeur autorisée
        if (Filiere::tryfrom($filiere) === null) {
            $erreurs['filiere'] = "Veuillez choisir une filière valide parmi la liste.";
        }

        //Au moins un choix de langage et parmi la liste autorisée
        if ($langages === []) {
            $erreurs['langages'] = "Veuillez choisir au moins un langage.";
        } else {
            foreach ($langages as $langage) {
                if (Langage::tryFrom($langage) === null) {
                    $erreurs['langages'] = "Veuillez choisir un langage parmi la liste.";
                    break;
                }
            }
        }

        //Message avec 300 caracs max
        if (mb_strlen($message) > 300) {
            $erreurs['message'] = "Le message ne peut dépasser 300 caractères.";
        }

        //Règlement coché
        if (!$reglement) {
            $erreurs['reglement'] = "Veuillez accepter le règlement.";
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
                <input name="age" type="number" placeholder="19" min="16" max="99" value = "<?= $age > 0 ? h((string) $age) : "" ?>"><br>
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
    </body>
</html>