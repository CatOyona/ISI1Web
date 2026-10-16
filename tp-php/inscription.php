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
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $prenom = champ('prenom');
    }
?>
<!DOCTYPE html>
    <html lang="fr">
    <head><meta charset="utf-8"><title>Bonjour PHP</title></head>
    <link rel="stylesheet" href="styles.css" />
    <body>
        <fieldset class = "formulaire">
        <legend>Formulaire d'inscription</legend>
        <form method = "POST">
            <label>Votre nom : *</label><br>
            <input name="nom" type="text" placeholder="Dupond" required><br>
            <label>Votre email : *</label><br>
            <input name="email" type="email" placeholder="mail@fournisseur.com" required><br>
            <label>Votre âge :</label><br>
            <input name="age" type="number" placeholder="19" min="16" max="99"><br>
            <label>Filière :</label><br>
            <select name="pets" id="pet-select">
                <option value="info">INFO</option>
                <option value="math">MATH</option>
                <option value="phys">PHYS</option>
                <option value="autre">AUTRE</option>
            </select><br>
            <label>Vos langages :</label><br>
            <div>
                <input type="checkbox" name="c++"/>
                <label>C++</label>
            </div>
            <div>
                <input type="checkbox" name="python"/>
                <label>Python</label>
            </div>
            <div>
                <input type="checkbox" name="Java"/>
                <label>Java</label>
            </div>
            <div>
                <input type="checkbox" name="php"/>
                <label>PHP</label>
            </div>
            <label>Message ?</label><br>
            <textarea name="story" rows="5" cols="33" maxlength="300"></textarea>
            <label>Accepter le règlement :</label><br>
            <div>
                <input type="checkbox" name="reglement"/>
                <label>J'accepte le règlement</label>
            </div>
            <input type="submit" value="Envoyer">
        </form>
    </fieldset>
    </body>
</html>