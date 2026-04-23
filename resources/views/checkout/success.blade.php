@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 flex items-center justify-center py-12 px-4">

    <div class="max-w-2xl w-full">

        <!-- Header -->
        <div class="text-center mb-10">
            <div class="w-20 h-20 mx-auto bg-green-100 text-green-600 rounded-full flex items-center justify-center shadow-sm">
                <i class="fas fa-check text-3xl"></i>
            </div>

            <h1 class="text-3xl font-bold text-gray-900 mt-6">Commande confirmée</h1>
            <p class="text-gray-500 mt-2">Merci ! Nous préparons votre commande avec soin.</p>
        </div>

        <!-- Card -->
        <div class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden">

            <!-- Top bar -->
            <div class="h-1 bg-primary"></div>

            <div class="p-6 sm:p-8 space-y-6">

                <!-- Order info -->
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs text-gray-400 uppercase">Commande</p>
                        <h2 class="text-lg font-bold text-gray-900">#{{ str_pad($commande->id, 5, '0', STR_PAD_LEFT) }}</h2>
                    </div>

                    <span class="px-3 py-1 text-xs font-medium rounded-full bg-green-100 text-green-700">
                        Confirmée
                    </span>
                </div>

                <!-- Livraison -->
                <div class="bg-gray-50 rounded-xl p-5 space-y-3">
                    <h3 class="text-sm font-semibold text-gray-700 flex items-center gap-2">
                        <i class="fas fa-truck text-primary"></i> Livraison
                    </h3>

                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <p class="text-gray-400 text-xs">Date</p>
                            <p class="font-semibold text-gray-800">
                                {{ \Carbon\Carbon::parse($commande->creneau->date)->translatedFormat('d M Y') }}
                            </p>
                        </div>

                        <div>
                            <p class="text-gray-400 text-xs">Horaire</p>
                            <p class="font-semibold text-gray-800">
                                {{ \Carbon\Carbon::parse($commande->creneau->heure_debut)->format('H:i') }}
                                -
                                {{ \Carbon\Carbon::parse($commande->creneau->heure_fin)->format('H:i') }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Total -->
                <div class="bg-primary text-white rounded-xl p-6 flex justify-between items-center">
                    <div>
                        <p class="text-xs opacity-80 uppercase">Total payé</p>
                        <p class="text-2xl font-bold">
                            {{ number_format($commande->prix_total, 0, ',', ' ') }} FCFA
                        </p>
                    </div>

                    <i class="fas fa-wallet text-3xl opacity-30"></i>
                </div>

                <!-- Message -->
                <p class="text-center text-sm text-gray-500 italic">
                    Vous serez contacté avant la livraison.
                </p>

            </div>
        </div>

        <!-- Buttons -->
        <div class="mt-8 flex flex-col sm:flex-row gap-3 justify-center">

            <a href="{{ url('/') }}"
               class="px-6 py-3 bg-primary text-white rounded-lg font-medium text-center hover:bg-secondary transition">
                Continuer mes achats
            </a>

            <a href="#"
               class="px-6 py-3 bg-white border border-gray-200 text-gray-700 rounded-lg font-medium text-center hover:bg-gray-50 transition">
                Suivre ma commande
            </a>

        </div>

    </div>
</div>
@endsection