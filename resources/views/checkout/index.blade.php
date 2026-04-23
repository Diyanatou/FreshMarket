@extends('layouts.app')

@section('content')
<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <nav class="flex mb-8" aria-label="Breadcrumb">
            <ol class="flex items-center space-x-2 text-sm text-gray-500">
                <li><a href="{{ url('/') }}" class="hover:text-primary transition-colors"><i class="fas fa-home"></i></a></li>
                <li><i class="fas fa-chevron-right text-[10px]"></i></li>
                <li><a href="{{ route('cart.index') }}" class="hover:text-primary transition-colors">Panier</a></li>
                <li><i class="fas fa-chevron-right text-[10px]"></i></li>
                <li class="text-primary font-medium">Validation</li>
            </ol>
        </nav>

        <h1 class="text-3xl font-black text-gray-900 text-center mb-10">Finaliser ma commande</h1>

        @if(session('error'))
        <div class="mb-6 bg-red-50 border border-red-100 text-red-600 px-4 py-3 rounded-xl flex items-center gap-3">
            <i class="fas fa-exclamation-circle text-lg"></i>
            <span class="font-medium">{{ session('error') }}</span>
        </div>
        @endif

        <form action="{{ route('checkout.process') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- Left: Forms -->
                <div class="lg:col-span-2 space-y-8">
                    
                    <!-- Step 1: Delivery Address (Mockup) -->
                    <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100">
                        <div class="flex items-center gap-4 mb-6">
                            <span class="w-8 h-8 rounded-full bg-primary text-white flex items-center justify-center font-black text-sm">1</span>
                            <h2 class="text-xl font-bold text-gray-900">Adresse de livraison</h2>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-1">
                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Ville</label>
                                <input type="text" name="ville" placeholder="Dakar" required class="w-full bg-white border border-gray-200 focus:ring-primary focus:border-primary rounded-xl text-sm font-bold text-gray-800 py-3 px-4">
                            </div>
                            <div class="space-y-1">
                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Quartier</label>
                                <input type="text" name="quartier" placeholder="Ex: Plateau, Almadies..." required class="w-full bg-white border border-gray-200 focus:ring-primary focus:border-primary rounded-xl text-sm py-3 px-4">
                            </div>
                            <div class="md:col-span-2 space-y-1">
                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Adresse précise</label>
                                <input type="text" name="adresse" placeholder="Rue, n° de porte, point de repère..." required class="w-full bg-white border border-gray-200 focus:ring-primary focus:border-primary rounded-xl text-sm py-3 px-4">
                            </div>
                        </div>
                    </div                    <!-- Step 2: Delivery Slot -->
                    @php
                        $jsonCreneaux = $creneaux->mapWithKeys(function($slots, $date) {
                            return [$date => $slots->map(function($s) {
                                return [
                                    'id' => $s->id,
                                    'label' => \Carbon\Carbon::parse($s->heure_debut)->format('H:i') . ' - ' . \Carbon\Carbon::parse($s->heure_fin)->format('H:i') . ($s->isFull() ? ' (Complet)' : ''),
                                    'isFull' => $s->isFull()
                                ];
                            })];
                        });
                    @endphp

                    <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100" 
                         x-data="{ 
                            activeDate: '', 
                            slotsByDate: {{ $jsonCreneaux->toJson() }}
                         }">
                        <div class="flex items-center gap-4 mb-8">
                            <span class="w-8 h-8 rounded-full bg-primary text-white flex items-center justify-center font-black text-sm">2</span>
                            <h2 class="text-xl font-bold text-gray-900">Planifier ma livraison</h2>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Date Selector -->
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Date de livraison</label>
                                <div class="relative">
                                    <select x-model="activeDate" class="w-full bg-gray-50 border-gray-100 focus:ring-primary focus:border-primary rounded-xl text-sm font-bold text-gray-800 py-4 px-5 appearance-none cursor-pointer">
                                        <option value="">Sélectionnez un jour...</option>
                                        @foreach($creneaux as $date => $slots)
                                        <option value="{{ $date }}">{{ \Carbon\Carbon::parse($date)->translatedFormat('l d F Y') }}</option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-gray-400">
                                        <i class="fas fa-calendar-alt"></i>
                                    </div>
                                </div>
                            </div>

                            <!-- Hour Selector -->
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Créneau horaire</label>
                                <div class="relative">
                                    <select name="creneau_id" required :disabled="!activeDate" class="w-full bg-gray-50 border-gray-100 focus:ring-primary focus:border-primary rounded-xl text-sm font-bold text-gray-800 py-4 px-5 appearance-none cursor-pointer disabled:opacity-50 disabled:cursor-not-allowed">
                                        <option value="">Choisir l'heure...</option>
                                        <template x-for="slot in (slotsByDate[activeDate] || [])" :key="slot.id">
                                            <option :value="slot.id" x-text="slot.label" :disabled="slot.isFull"></option>
                                        </template>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-gray-400">
                                        <i class="fas fa-clock"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 flex items-center gap-3 bg-blue-50/50 p-4 rounded-2xl border border-blue-100/50">
                            <i class="fas fa-info-circle text-primary"></i>
                            <p class="text-[11px] text-gray-600 leading-relaxed font-medium">
                                Les horaires sont limités en nombre de commandes pour garantir la qualité de service.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Right: Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 sticky top-8">
                        <h3 class="text-lg font-black text-gray-900 mb-6 uppercase tracking-tight">Récapitulatif</h3>
                        
                        <div class="space-y-4 mb-6 max-h-60 overflow-y-auto pr-2 no-scrollbar">
                            @foreach($panier->lignes as $ligne)
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-gray-50 rounded-lg border border-gray-100 overflow-hidden flex-shrink-0">
                                    @if($ligne->produit->image)
                                        <img src="{{ asset('storage/'.$ligne->produit->image) }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-gray-200">
                                            <i class="fas fa-image text-xs"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs font-bold text-gray-800 truncate">{{ $ligne->produit->nom }}</p>
                                    <p class="text-[10px] text-gray-500 font-medium">Qté: {{ $ligne->quantite }}</p>
                                </div>
                                <span class="text-xs font-black text-gray-900">{{ number_format($ligne->sousTotal(), 0, ',', ' ') }} <small>FCFA</small></span>
                            </div>
                            @endforeach
                        </div>

                        <div class="pt-6 border-t border-gray-50 space-y-4 mb-8">
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-500 font-medium">Sous-total :</span>
                                <span class="text-gray-900 font-black">{{ number_format($panier->total(), 0, ',', ' ') }} FCFA</span>
                            </div>
                            <div class="flex justify-between items-center text-sm pb-4 border-b border-gray-50">
                                <span class="text-gray-500 font-medium">Frais de livraison :</span>
                                <span class="text-primary font-black uppercase text-[10px] tracking-widest">Offert</span>
                            </div>
                            <div class="flex justify-between items-center text-xl">
                                <span class="font-black text-gray-900">Total :</span>
                                <span class="font-black text-primary">{{ number_format($panier->total(), 0, ',', ' ') }} FCFA</span>
                            </div>
                        </div>

                        <button type="submit" class="w-full flex items-center justify-center gap-3 px-8 py-4 bg-primary text-white font-black rounded-full ">
                            Confirmer la commande
                            <i class="fas fa-check-circle group-hover:scale-110 transition-transform"></i>
                        </button>

                        <p class="mt-6 text-[10px] text-center text-gray-400 font-medium italic">
                            En confirmant, vous acceptez nos conditions générales de vente.
                        </p>
                    </div>
                </div>

            </div>
        </form>

    </div>
</div>
@endsection
