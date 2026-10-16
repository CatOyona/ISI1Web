<?php
    declare(strict_types=1);
    function h(string $texte): string {
        return htmlspecialchars($texte, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }
    function champ(string $cle): string {
        $valeur = $_POST[$cle] ?? '';
        return is_string($valeur) ? trim($valeur) : '';
    }
    $erreurs = [];
    $message = null;
    $prenom = '';
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $prenom = champ('prenom');
    }
?>
<!DOCTYPE html>
    <html lang="fr">
    <head><meta charset="utf-8"><title>Bonjour PHP</title></head>
    <link rel="stylesheet" href="styles.css" />
    <body>
        <?php
            if ($prenom === '') {
                echo '<form method="POST"> <input name="prenom" type="text" placeholder="Votre Prénom"> <input type="submit" value="Envoyer"> </form>';
            } else {
                echo "Bonjour ".h($prenom)."!";
            }
        ?>
    </body>
</html>