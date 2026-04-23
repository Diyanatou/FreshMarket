@extends('layouts.app')

@section('content')
<div class="bg-gray-50 min-h-screen py-16 flex items-center justify-center">
    <div class="max-w-xl w-full px-4">
        
        <!-- Header Section -->
        <div class="text-center mb-10">
            <div class="relative inline-block mb-6">
                <div class="w-24 h-24 bg-primary/10 text-primary rounded-full flex items-center justify-center animate-bounce shadow-xl shadow-blue-100">
                    <i class="fas fa-check text-4xl"></i>
                </div>
                <div class="absolute -top-1 -right-1 w-8 h-8 bg-accent rounded-full flex items-center justify-center shadow-lg border-4 border-white">
                    <i class="fas fa-star text-primary text-[10px]"></i>
                </div>
            </div>
            <h1 class="text-4xl font-black text-gray-900 mb-3 tracking-tight">C'est validé !</h1>
            <p class="text-gray-500 font-medium">Merci pour votre confiance. Votre commande est entre nos mains.</p>
        </div>

        <!-- Receipt Card -->
        <div class="bg-white rounded-[40px] shadow-2xl shadow-blue-900/5 border border-gray-100 overflow-hidden relative">
            <!-- Decorative top band -->
            <div class="h-2 bg-primary"></div>
            
            <div class="p-10">
                <div class="flex justify-between items-center mb-8 border-b border-gray-50 pb-6">
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">N° de commande</p>
                        <h2 class="text-xl font-black text-primary">#{{ str_pad($commande->id, 5, '0', STR_PAD_LEFT) }}</h2>
                    </div>
                    <div class="text-right">
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Statut</p>
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-green-50 text-green-600 text-[10px] font-black uppercase">
                            <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Confirmée
                        </span>
                    </div>
                </div>

                <div class="space-y-6">
                    <!-- Delivery Info -->
                    <div class="bg-gray-50 rounded-3xl p-6 border border-gray-100/50">
                        <h3 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-4 flex items-center gap-2">
                            <i class="fas fa-truck text-primary"></i> Infos Livraison
                        </h3>
                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">Date prévue</p>
                                <p class="text-sm font-bold text-gray-900">{{ \Carbon\Carbon::parse($commande->creneau->date)->translatedFormat('l d F') }}</p>
                            </div>
                            <div>
                                <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">Horaire</p>
                                <p class="text-sm font-bold text-gray-900">
                                    {{ \Carbon\Carbon::parse($commande->creneau->heure_debut)->format('H:i') }} - {{ \Carbon\Carbon::parse($commande->creneau->heure_fin)->format('H:i') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Total -->
                    <div class="flex items-center justify-between p-6 bg-primary text-white rounded-3xl shadow-lg shadow-blue-100">
                        <div>
                            <p class="text-[10px] font-black uppercase tracking-widest opacity-70 mb-1">Total payé</p>
                            <h4 class="text-2xl font-black">{{ number_format($commande->prix_total, 0, ',', ' ') }} <small class="text-xs">FCFA</small></h4>
                        </div>
                        <i class="fas fa-wallet text-3xl opacity-20"></i>
                    </div>
                </div>

                <!-- Next Steps -->
                <div class="mt-10 pt-8 border-t border-dashed border-gray-100 text-center">
                    <p class="text-sm text-gray-500 leading-relaxed italic">
                        "Notre équipe prépare vos produits frais avec soin. Vous recevrez un appel de notre livreur dès son départ."
                    </p>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="mt-12 flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="{{ url('/') }}" class="w-full sm:w-auto px-10 py-4 bg-primary text-white font-black rounded-full hover:bg-secondary transition-all shadow-xl shadow-blue-100 group">
                Continuer mes achats
                <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
            </a>
            <a href="#" class="w-full sm:w-auto px-10 py-4 bg-white text-gray-700 font-bold rounded-full border border-gray-200 hover:bg-gray-50 transition-all">
                Suivre ma commande
            </a>
        </div>

    </div>
</div>
@endsection
