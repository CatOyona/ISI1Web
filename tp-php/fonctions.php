<?php
    declare(strict_types=1);

    function moyenne(array $notes): float {
        if ($notes === []) {
            return 0.0;
        }
        $sum = 0;
        $count = 0;
        foreach ($notes as $etudiant) {
            $sum += $etudiant->note;
            $count++;
        }
        return round($sum/$count, 2);
    }

    function estAdmis(float $note, float $seuil = 10.0): bool {
        return $note >= $seuil;
    }

    function meilleurEtudiant(array $notes): ?string {
        if ($notes === []) {
            return null;
        }

        $meilleur = reset($notes)->nom;
        $max = reset($notes)->note;
        foreach ($notes as $etudiant) {
            if ($etudiant->note > $max) {
                $max = $etudiant->note;
                $meilleur = $etudiant->nom;
            }
        }
        return $meilleur;
    }

    function maxEtudiant(array $notes): float {
        if ($notes === []) {
            return 0;
        }

        $max = reset($notes)->note;
        foreach ($notes as $etudiant) {
            if ($etudiant->note > $max) {
                $max = $etudiant->note;
            }
        }
        return $max;
    }

    function minEtudiant(array $notes): float {
        if ($notes === []) {
            return 0;
        }

        $min = reset($notes)->note;
        foreach ($notes as $etudiant) {
            if ($etudiant->note < $min) {
                $min = $etudiant->note;
            }
        }
        return $min;
    }

    function h(string $texte): string {
        return htmlspecialchars($texte, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }
    
    function champ(string $cle): string {
        $valeur = $_POST[$cle] ?? '';
        return is_string($valeur) ? trim($valeur) : '';
    }

    function champTab(string $cle): array {
        $valeur = $_POST[$cle] ?? [];
        if (!is_array($valeur)) {
            return [];
        }
        return array_values(array_filter($valeur, 'is_string'));
    }

    function champBool(string $cle): bool {
        return isset($_POST[$cle]);
    }

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

    //Nom obligatoire et entre 2 et 50 caracs
    function validerNom(string $nom): ?string {
        if ($nom === '') {
            return "Le nom est obligatoire";
        } elseif (mb_strlen($nom) > 50 || mb_strlen($nom) < 2) {
            return "Le nom doit être compris entre 2 et 50 caractères.";
        }
        return null;
    }

    //Email au fomat valide et obligatoire
    function validerEmail(string $email): ?string {
        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            return 'Adresse mail invalide.';
        }
        return null;
    }

    //Âge entier entre 16 et 99
    function validerAge(string $age): ?string {
        if ($age !== '' && !filter_var($age, FILTER_VALIDATE_INT, ['options' => ['min_range' => 16, 'max_range' => 99]])) {
            return "Entrez un âge entier compris entre 16 et 99.";
        }
        return null;
    }

    //Filière avec valeur autorisée
    function validerFiliere(string $filiere): ?string {
        if (Filiere::tryfrom($filiere) === null) {
            return "Veuillez choisir une filière valide parmi la liste.";
        }
        return null;
    }

    //Au moins un choix de langage et parmi la liste autorisée
    function validerLangages(array $langages): ?string {
        if ($langages === []) {
            return "Veuillez choisir au moins un langage.";
        } else {
            foreach ($langages as $langage) {
                if (Langage::tryFrom($langage) === null) {
                    return "Veuillez choisir un langage parmi la liste.";
                }
            }
        }
        return null;
    }

    //Message avec 300 caracs max
    function validerMessage(string $message): ?string {
        if (mb_strlen($message) > 300) {
            return "Le message ne peut dépasser 300 caractères.";
        }
        return null;
    }

    //Règlement coché
    function validerReglement(bool $reglement): ?string {
        if (!$reglement) {
            return "Veuillez accepter le règlement.";
        }
        return null;
    }