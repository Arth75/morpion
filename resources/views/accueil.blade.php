@extends('layouts.app')

@section('titre', 'Accueil')

@section('contenu')
    <h1>Le Morpion</h1>

    @if ($gagnant)
        <p class="resultat"><strong>{{ $gagnant }} gagne !</strong>
            {{ $gagnant === 'X' ? 'O' : 'X' }} perd.</p>
    @elseif ($nul)
        <p class="resultat"><strong>Match nul !</strong></p>
    @else
        <p class="resultat">Au tour de : <strong>{{ $joueur }}</strong></p>
    @endif

    <table class="morpion">
        @foreach ($grille as $i => $ligne)
            <tr>
                @foreach ($ligne as $j => $case)
                    <td>
                        @if ($case === '' && !$gagnant)
                            <a href="/jouer/{{ $i }}/{{ $j }}" class="case-vide">&nbsp;</a>
                        @else
                            {{ $case }}
                        @endif
                    </td>
                @endforeach
            </tr>
        @endforeach
    </table>

    <p class="resultat"><a href="/reset">Nouvelle partie</a></p>
@endsection