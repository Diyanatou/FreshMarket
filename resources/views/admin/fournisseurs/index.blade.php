@extends('layouts.dashboard')

@section('title', 'Fournisseurs')

@section('content')
<div class="flex gap-6">

    <!-- FORM -->
    <div class="w-1/3 bg-white p-5 rounded-lg border shadow-sm">
        <h3 class="font-bold mb-4">Ajouter fournisseur</h3>

        <form method="POST" action="{{ route('fournisseurs.store') }}" class="space-y-3">
            @csrf

            <input name="nom" placeholder="Nom"
                   class="w-full border rounded px-3 py-2" required>

            <input name="telephone" placeholder="Téléphone"
                   class="w-full border rounded px-3 py-2">

            <input name="email" placeholder="Email"
                   class="w-full border rounded px-3 py-2">

            <textarea name="adresse" placeholder="Adresse"
                      class="w-full border rounded px-3 py-2"></textarea>

            <button class="w-full bg-primary hover:bg-secondary text-white py-2 rounded">
                Ajouter
            </button>
        </form>
    </div>

    <!-- TABLE -->
    <div class="w-2/3 bg-white p-5 rounded-lg border shadow-sm">

        <h3 class="font-bold mb-4">Liste fournisseurs</h3>

        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-xs uppercase">
                <tr>
                    <th class="p-2">Nom</th>
                    <th class="p-2">Téléphone</th>
                    <th class="p-2">Email</th>
                    <th class="p-2">Adresse</th> <!-- ✅ AJOUT -->
                    <th class="p-2 text-center">Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse($fournisseurs as $f)
                <tr class="border-t hover:bg-gray-50">

                    <td class="p-2 font-bold">{{ $f->nom }}</td>
                    <td class="p-2">{{ $f->telephone }}</td>
                    <td class="p-2">{{ $f->email }}</td>

                    <!-- ✅ AFFICHAGE ADRESSE -->
                    <td class="p-2 text-gray-600">
                        {{ $f->adresse ?? '—' }}
                    </td>

                    <td class="p-2 flex justify-center gap-3">

                        <a href="{{ route('fournisseurs.edit', $f) }}"
                           class="text-blue-600">
                            <i class="fas fa-edit"></i>
                        </a>

                        <form method="POST"
                              action="{{ route('fournisseurs.destroy', $f) }}">
                            @csrf
                            @method('DELETE')

                            <button class="text-red-500">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>

                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center p-4 text-gray-400">
                        Aucun fournisseur trouvé
                    </td>
                </tr>
                @endforelse
            </tbody>

        </table>

    </div>
</div>
@endsection