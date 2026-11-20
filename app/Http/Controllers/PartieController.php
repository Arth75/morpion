<?php
namespace App\Http\Controllers;

use App\Models\Partie;
use Illuminate\Http\Request;

class PartieController extends Controller
{
    public function index()
    {
        $parties = Partie::withCount('coups')->latest('id')->get();
        return view('parties.index', compact('parties'));
    }

    public function store()
    {
        $partie = Partie::create();
        return redirect()->route('parties.show', $partie);
    }

    public function show(Partie $partie)
    {
        $cases = $partie->cases();
        $coups = $partie->coups()->orderBy('id')->get();
        return view('parties.show', compact('partie', 'cases', 'coups'));
    }

    public function jouer(Request $request, Partie $partie)
    {
        $donnees = $request->validate([
            'position' => ['required', 'integer', 'between:0,8'],
        ]);
        $position = (int) $donnees['position'];

        if ($partie->estTerminee()) {
            return back()->withErrors(['position' => 'La partie est terminée.']);
        }

        if ($partie->cases()[$position] !== '-') {
            return back()->withErrors(['position' => 'Cette case est déjà prise.']);
        }

        $symbole = $partie->joueur_courant;
        $partie->placer($position);
        $partie->coups()->create([
            'position' => $position,
            'symbole'  => $symbole,
        ]);

        return redirect()->route('parties.show', $partie);
    }

    public function annuler(Partie $partie)
    {
        $partie->annulerDernierCoup();
        return redirect()->route('parties.show', $partie);
    }
}