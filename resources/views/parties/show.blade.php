@extends('layouts.app')

@section('titre', 'Partie ' . $partie->id)

@section('contenu')
    <h1>Partie n°{{ $partie->id }}</h1>

    <p class="centre"><a href="{{ route('parties.index') }}">Toutes les parties</a></p>

    @if ($partie->gagnant())
        <p class="centre"><strong>{{ $partie->gagnant() }} a gagné !</strong></p>
    @elseif ($partie->estNulle())
        <p class="centre"><strong>Match nul</strong></p>
    @else
        <p class="centre">Au tour de : <strong>{{ $partie->joueur_courant }}</strong></p>
    @endif

    @error('position')
        <p class="erreur">{{ $message }}</p>
    @enderror

    <form method="POST" action="{{ route('parties.jouer', $partie) }}">
        @csrf
        <table class="morpion">
            @foreach (array_chunk($cases, 3, true) as $ligne)
                <tr>
                    @foreach ($ligne as $position => $case)
                        <td>
                            @if ($case !== '-')
                                {{ $case }}
                            @elseif (!$partie->estTerminee())
                                <button type="submit" name="position" value="{{ $position }}" class="case-vide">&nbsp;</button>
                            @endif
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </table>
    </form>

    <div class="centre">
        @if ($partie->estTerminee())
            <form method="POST" action="{{ route('parties.store') }}">
                @csrf
                <button type="submit">Nouvelle partie</button>
            </form>
        @endif

        @if ($coups->isNotEmpty())
            <form method="POST" action="{{ route('parties.annuler', $partie) }}">
                @csrf
                @method('DELETE')
                <button type="submit">Annuler le dernier coup</button>
            </form>
        @endif
    </div>

    <h2 class="centre">Historique</h2>
    <ol class="historique">
        @foreach ($coups as $coup)
            <li>{{ $coup->symbole }} en case {{ $coup->position }}</li>
        @endforeach
    </ol>
@endsection