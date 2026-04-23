@extends('layouts.dashboard')

@section('title', 'Gestion Utilisateurs')

@section('content')

<div class="mb-8 flex justify-between items-center">

    <h2 class="text-3xl font-black text-gray-900">Utilisateurs</h2>

    <form method="GET" action="{{ route('admin.users.index') }}">
    <select name="role" onchange="this.form.submit()"
        class="px-4 py-2 border rounded-xl text-gray-700">

        <option value="">Tous les rôles</option>
        <option value="client" {{ request('role') == 'client' ? 'selected' : '' }}>Client</option>
        <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>

    </select>
    </form>

    <a href="{{ route('admin.users.create') }}" 
       class="px-6 py-3 bg-primary text-white font-black rounded-xl hover:bg-secondary transition-all flex items-center gap-2">
        <i class="fas fa-plus"></i> Nouveau Membre
    </a>

</div>

{{-- Messages --}}
@if(session('success'))
<div class="mb-6 p-4 bg-green-50 border border-green-100 text-green-700 rounded-2xl">
    {{ session('success') }}
</div>
@endif

<div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">

    <table class="w-full text-left">
        <thead>
            <tr class="bg-gray-50 border-b border-gray-100">
                <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase">Utilisateur</th>
                <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase">Email</th>
                <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase">Rôle</th>
                <th class="px-6 py-4 text-right text-xs font-bold text-gray-400 uppercase">Actions</th>
            </tr>
        </thead>

        <tbody class="divide-y divide-gray-50">

            @forelse($users as $user)
            <tr class="hover:bg-gray-50">

                <td class="px-6 py-4 font-semibold text-gray-900">
                    {{ $user->prenom }} {{ $user->nom }}
                </td>

                <td class="px-6 py-4 text-gray-500">
                    {{ $user->email }}
                </td>

                <td class="px-6 py-4">
                    <span class="px-3 py-1 rounded-full text-xs font-bold uppercase
                        {{ optional($user->role)->nom === 'admin'
                            ? 'bg-purple-100 text-purple-700'
                            : 'bg-blue-100 text-blue-700' }}">
                        {{ optional($user->role)->nom ?? '—' }}
                    </span>
                </td>

                <td class="px-6 py-4 text-right">
                    <a href="{{ route('admin.users.edit', $user->id) }}" class="text-blue-500 mr-2">
                        <i class="fas fa-edit"></i>
                    </a>

                    @if($user->id !== auth()->id())
                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button class="text-red-500">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                    @endif
                </td>

            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center py-6 text-gray-400">
                    Aucun utilisateur trouvé
                </td>
            </tr>
            @endforelse

        </tbody>
    </table>

</div>

@endsection

{{-- JS FILTRE --}}
<script>
document.getElementById('roleFilter').addEventListener('change', function () {
    let role = this.value;

    let url = "{{ route('admin.users.index') }}";

    if (role) {
        url += "?role=" + role;
    }

    window.location.href = url;
});
</script>