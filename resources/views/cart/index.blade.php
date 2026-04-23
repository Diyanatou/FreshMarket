@extends('layouts.app')

@section('content')
<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Breadcrumb & Title -->
        <nav class="flex mb-8" aria-label="Breadcrumb">
            <ol class="flex items-center space-x-2 text-sm text-gray-500">
                <li><a href="{{ url('/') }}" class="hover:text-primary transition-colors"><i class="fas fa-home"></i></a></li>
                <li><i class="fas fa-chevron-right text-[10px]"></i></li>
                <li class="text-primary font-medium">Mon Panier</li>
            </ol>
        </nav>

        <h1 class="text-3xl font-black text-gray-900 text-center mb-10">Mon Panier d'Achat</h1>

        @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl flex items-center gap-3">
            <i class="fas fa-check-circle text-lg"></i>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
        @endif

        @if($panier->lignes->isEmpty())
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-12 text-center">
            <div class="w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-shopping-basket text-4xl text-gray-200"></i>
            </div>
            <h2 class="text-xl font-bold text-gray-800 mb-2">Votre panier est vide</h2>
            <p class="text-gray-500 mb-8">On dirait que vous n'avez pas encore fait votre choix.</p>
            <a href="{{ url('/') }}" class="inline-flex items-center justify-center px-8 py-3 bg-[#00B207] text-white font-bold rounded-full hover:bg-green-600 transition-all shadow-lg shadow-green-100">
                Commencer mes achats
            </a>
        </div>
        @else
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Articles Table -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="text-xs font-bold text-gray-400 uppercase tracking-widest border-b border-gray-50">
                                    <th class="px-6 py-5">Produit</th>
                                    <th class="px-6 py-5">Prix</th>
                                    <th class="px-6 py-5">Quantité</th>
                                    <th class="px-6 py-5">Sous-total</th>
                                    <th class="px-6 py-5 w-10"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @foreach($panier->lignes as $ligne)
                                <tr class="group">
                                    <td class="px-6 py-5">
                                        <div class="flex items-center gap-4">
                                            <div class="w-20 h-20 bg-gray-50 rounded-xl overflow-hidden border border-gray-100 flex-shrink-0">
                                                @if($ligne->produit->image)
                                                    <img src="{{ asset('storage/'.$ligne->produit->image) }}" class="w-full h-full object-cover">
                                                @else
                                                    <div class="w-full h-full flex items-center justify-center">
                                                        <i class="fas fa-image text-gray-200 text-2xl"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <span class="font-bold text-gray-800">{{ $ligne->produit->nom }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5">
                                        <span class="text-gray-600 font-medium">{{ number_format($ligne->produit->prix, 0, ',', ' ') }} <small>FCFA</small></span>
                                    </td>
                                    <td class="px-6 py-5">
                                        <form action="{{ route('cart.update', $ligne) }}" method="POST" id="update-form-{{ $ligne->id }}" class="flex items-center w-32 bg-gray-50 rounded-full p-1">
                                            @csrf
                                            @method('PATCH')
                                            <button type="button" onclick="changeQty({{ $ligne->id }}, -1)" class="w-8 h-8 rounded-full flex items-center justify-center bg-white text-gray-500 hover:text-primary shadow-sm transition-colors">
                                                <i class="fas fa-minus text-[10px]"></i>
                                            </button>
                                            <input type="number" name="quantite" id="qty-{{ $ligne->id }}" value="{{ $ligne->quantite }}" min="1" class="w-full bg-transparent text-center text-sm font-bold border-0 focus:ring-0" readonly onchange="this.form.submit()">
                                            <button type="button" onclick="changeQty({{ $ligne->id }}, 1)" class="w-8 h-8 rounded-full flex items-center justify-center bg-white text-gray-500 hover:text-primary shadow-sm transition-colors">
                                                <i class="fas fa-plus text-[10px]"></i>
                                            </button>
                                        </form>
                                    </td>
                                    <td class="px-6 py-5 text-gray-900 font-black">
                                        {{ number_format($ligne->sousTotal(), 0, ',', ' ') }} <small>FCFA</small>
                                    </td>
                                    <td class="px-6 py-5">
                                        <form action="{{ route('cart.remove', $ligne) }}" method="POST" onsubmit="return confirm('Retirer cet article ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-8 h-8 flex items-center justify-center text-gray-300 hover:text-red-500 hover:bg-red-50 rounded-full transition-all">
                                                <i class="fas fa-times-circle"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="p-6 bg-gray-50/50 flex flex-wrap justify-between items-center gap-4 border-t border-gray-100">
                        <a href="{{ url('/') }}" class="px-6 py-3 bg-white text-gray-700 font-bold rounded-full border border-gray-200 hover:bg-gray-50 transition-all text-sm shadow-sm">
                            Retour à la boutique
                        </a>
                        <form action="{{ route('cart.clear') }}" method="POST" onsubmit="return confirm('Vider tout le panier ?')">
                            @csrf
                            <button type="submit" class="px-6 py-3 bg-white text-red-500 font-bold rounded-full border border-red-600">
                                Vider le panier
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 sticky top-8">
                    <h3 class="text-lg font-black text-gray-900 mb-6">Résumé de la commande</h3>
                    
                    <div class="space-y-4 mb-8">
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-500">Sous-total :</span>
                            <span class="text-gray-900 font-bold">{{ number_format($panier->total(), 0, ',', ' ') }} FCFA</span>
                        </div>
                        <div class="flex justify-between items-center text-sm pb-4 border-b border-gray-50">
                            <span class="text-gray-500">Livraison :</span>
                            <span class="text-green-600 font-bold">Gratuite</span>
                        </div>
                        <div class="flex justify-between items-center text-lg">
                            <span class="font-bold text-gray-900">Total :</span>
                            <span class="font-black text-primary">{{ number_format($panier->total(), 0, ',', ' ') }} FCFA</span>
                        </div>
                    </div>

                    <a href="{{ route('checkout.index') }}" class="w-full flex items-center justify-center gap-3 px-8 py-4 bg-primary text-white font-black rounded-full">
                        Passer à la commande
                        <i class="fas fa-arrow-right text-xs group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>
            </div>

        </div>
        @endif

    </div>
</div>

<script>
function changeQty(id, delta) {
    const input = document.getElementById('qty-' + id);
    const form = document.getElementById('update-form-' + id);
    let val = parseInt(input.value) + delta;
    if (val < 1) val = 1;
    input.value = val;
    form.submit();
}
</script>
@endsection
