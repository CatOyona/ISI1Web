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
?>