<?php
declare(strict_types=1);
$prenom = 'Ismaël';
$date = date('d/m/Y');
$langages = ['Java', 'C++', 'Python'];
?>
<!DOCTYPE html>
    <html lang="fr">
    <head><meta charset="utf-8"><title>Bonjour PHP</title></head>
    <body>
        <h1>Bonjour <?= $prenom ?> !</h1>
        <p>Date du jour: <?= $date ?>.</p>

        <p>Mes langages préférés:</p>
        <ul>
            <?php
                foreach ($langages as $langage) {
                    echo "<li>$langage</li>";
                }
            ?>
        </ul>
        </table>
    </body>
</html>