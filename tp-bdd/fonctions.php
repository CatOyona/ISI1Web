<?php
    declare(strict_types=1);
    function h(string $texte): string {
        return htmlspecialchars($texte, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }

    function champ(string $cle): string {
        $valeur = $_POST[$cle] ?? '';
        return is_string($valeur) ? trim($valeur) : '';
    }

    /** Les mots de passe ne sont jamais « trimés » : un espace peut en faire partie. */
    function champMotDePasse(string $cle): string {
        $valeur = $_POST[$cle] ?? '';
        return is_string($valeur) ? $valeur : '';
    }

    function afficherErreur(array $erreurs, string $cle): void {
        if (isset($erreurs[$cle])) {
            echo '<div class="erreur">' . h($erreurs[$cle]) . '</div>';
        }
    }
