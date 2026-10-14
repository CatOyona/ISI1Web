<?php
    declare(strict_types=1);
    enum Mention: string {
        case Ajourne = 'Ajourné';
        case Passable = 'Passable';
        case Bien = 'Bien';
        case TresBien = 'Très bien';
        public static function depuisNote(float $note): self {
            return match (true) {
                $note >= 16 => self::TresBien,
                $note >= 14 => self::Bien,
                $note >= 10 => self::Passable,
                default => self::Ajourne,
            };
        }
    }

    final readonly class Etudiant {
        public function __construct(
        public string $nom,
        public float $note,
        ) {}
        public function mention(): Mention {
            return Mention::depuisNote($this->note);
        }
    }
    #$ada = new Etudiant(nom: 'Ada', note: 15.5);
    #echo $ada->nom . ' : ' . $ada->mention()->value . "\n"; // Ada : Bien
    #$ada->note = 12;

?>