<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Partie extends Model
{
    protected $fillable = ['plateau', 'joueur_courant'];

    private const ALIGNEMENTS = [
        [0, 1, 2], [3, 4, 5], [6, 7, 8],
        [0, 3, 6], [1, 4, 7], [2, 5, 8],
        [0, 4, 8], [2, 4, 6],
    ];

    public function coups(): HasMany
    {
        return $this->hasMany(Coup::class);
    }

    public function cases(): array
    {
        return str_split($this->plateau);
    }

    public function placer(int $position): void
    {
        $plateau = $this->plateau;
        $plateau[$position] = $this->joueur_courant;
        $this->plateau = $plateau;
        $this->joueur_courant = $this->joueur_courant === 'X' ? 'O' : 'X';
        $this->save();
    }

    public function gagnant(): ?string
    {
        $c = $this->cases();
        foreach (self::ALIGNEMENTS as [$a, $b, $d]) {
            if ($c[$a] !== '-' && $c[$a] === $c[$b] && $c[$a] === $c[$d]) {
                return $c[$a];
            }
        }
        return null;
    }

    public function estNulle(): bool
    {
        return !str_contains($this->plateau, '-') && $this->gagnant() === null;
    }

    public function estTerminee(): bool
    {
        return $this->gagnant() !== null || $this->estNulle();
    }

    public function statut(): string
    {
        if ($this->gagnant() !== null) {
            return 'Gagnée par ' . $this->gagnant();
        }
        return $this->estNulle() ? 'Match nul' : 'En cours';
    }

    public function annulerDernierCoup(): void
    {
        $coup = $this->coups()->latest('id')->first();
        if ($coup === null) {
            return;
        }

        $plateau = $this->plateau;
        $plateau[$coup->position] = '-';
        $this->plateau = $plateau;
        $this->joueur_courant = $coup->symbole;
        $this->save();

        $coup->delete();
    }
}