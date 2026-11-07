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

    function validerNom(string $nom): ?string {
        if (preg_match('/^[A-Za-z0-9_]{3,30}\z/', $nom) !== 1) {
            return "Le nom est obligatoire, entre 3 et 30 caractères, composé de chiffres, lettres et _";
        }
        return null;
    }

    function validerPassword(string $password): ?string {
        if (mb_strlen($password) < 8) {
            return "Le mot de passe doit au moins faire 8 caractères";
        }
        return null;
    }

    function validerCPassword(string $password, string $cpassword): ?string {
        if ($password !== $cpassword) {
            return "Les mots de passe ne correspondent pas";
        }
        return null;
    }
