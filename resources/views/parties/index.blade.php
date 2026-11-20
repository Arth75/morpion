@extends('layouts.app')

@section('titre', 'Parties')

@section('contenu')
    <h1>Le Morpion</h1>

    <form method="POST" action="{{ route('parties.store') }}" class="centre">
        @csrf
        <button type="submit">Nouvelle partie</button>
    </form>

    <table class="tableau">
        <thead>
            <tr>
                <th>N°</th>
                <th>Créée le</th>
                <th>Statut</th>
                <th>Coups</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($parties as $partie)
                <tr>
                    <td>{{ $partie->id }}</td>
                    <td>{{ $partie->created_at->format('d/m/Y H:i') }}</td>
                    <td>{{ $partie->statut() }}</td>
                    <td>{{ $partie->coups_count }}</td>
                    <td><a href="{{ route('parties.show', $partie) }}">Reprendre</a></td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">Aucune partie enregistrée.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection