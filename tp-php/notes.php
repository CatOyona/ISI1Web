<?php
    declare(strict_types=1);
    require_once __DIR__ . '/fonctions.php';
    require_once __DIR__ . '/modele.php';

    $notes = [
    new Etudiant('Ada', 17.5),
    new Etudiant('Alan', 14.0),
    new Etudiant('Grace', 9.5),
    new Etudiant('Linus', 12.0),
    new Etudiant('Margaret', 6.5)
    ];

    array_push($notes, new Etudiant('Thomas', 12));

?>
<!DOCTYPE html>
    <html lang="fr">
    <head><meta charset="utf-8"><title>Bonjour PHP</title></head>
    <link rel="stylesheet" href="styles.css" />
    <body>
        <p>Notes:</p>
        <table>
            <tr>
                <th>Nom</th>
                <th>Note</th>
                <th>Mention</th>
            </tr>
            <?php foreach ($notes as $etudiant): ?>
                    <tr class="<?= !estAdmis($etudiant->note) ? 'echec' : '' ?>">
                    <td><?= $etudiant->nom ?></td>
                    <td><?= $etudiant->note ?></td>
                    <td><?= $etudiant->mention()->value ?></td>
                    </tr>
            <?php endforeach ?>
            </tr>
        </table>
        <p>Moyenne: <?php echo(moyenne($notes)) ?></p>
        <p>Note min: <?php echo(minEtudiant($notes)) ?></p>
        <p>Note max: <?php echo(maxEtudiant($notes)) ?></p>
        <p>Meilleur étudiant: <?php echo(meilleurEtudiant($notes)) ?></p>
        <p>Tentative de modifier un étudiant:
            <?php try {$notes[0]->note = 20;} catch (Error $e) {
                echo htmlspecialchars($e->getMessage());}
            ?>
        </p>
    </body>
</html>