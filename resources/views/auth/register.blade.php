<x-guest-layout>
    <div class="min-h-screen bg-gradient-to-br from-purple-600 via-purple-700 to-indigo-800 flex items-center justify-center p-4">
        <div class="w-full max-w-6xl grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
            
            <!-- Section gauche - Illustration (identique à login) -->
            <div class="w-80 h-80 bg-center bg-cover bg-no-repeat rounded-full flex items-center justify-center relative overflow-hidden" style="background-image: url('/image/miharindrano.png');">
                <!-- Ton contenu ici -->
            </div>

            <!-- Section droite - Formulaire d'inscription -->
            <div class="w-full max-w-md mx-auto">
                <div class="bg-white rounded-3xl shadow-2xl p-8 space-y-6">
                    <div class="text-center space-y-2">
                        <div class="inline-block bg-gradient-to-r from-purple-600 to-indigo-600 text-white px-6 py-2 rounded-full text-sm font-medium">
                            Bienvenue !
                        </div>
                        <h2 class="text-2xl font-bold text-gray-800 mt-4">
                            Créez votre compte
                        </h2>
                    </div>

                    <!-- Session Status -->
                    <x-auth-session-status class="mb-4" :status="session('status')" />

                    <form method="POST" action="{{ route('register') }}" class="space-y-6">
                        @csrf

                        <!-- Name -->
                        <div class="space-y-2">
                            <label for="name" class="block text-sm font-medium text-gray-700">
                                Nom
                            </label>
                            <div class="relative">
                                <x-text-input id="name" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-purple-500 focus:ring-0 transition-colors duration-200 bg-gray-50 focus:bg-white" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.121L3 15l7-7 3 3 7-7L21 7l-9 9-3-3z"></path>
                                    </svg>
                                </div>
                            </div>
                            <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-600 text-sm" />
                        </div>

                        <!-- Email Address -->
                        <div class="space-y-2">
                            <label for="email" class="block text-sm font-medium text-gray-700">
                                Adresse email
                            </label>
                            <div class="relative">
                                <x-text-input id="email" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-purple-500 focus:ring-0 transition-colors duration-200 bg-gray-50 focus:bg-white" type="email" name="email" :value="old('email')" required autocomplete="username" />
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                                    </svg>
                                </div>
                            </div>
                            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-600 text-sm" />
                        </div>

                        <!-- Password -->
                        <div class="space-y-2">
                            <label for="password" class="block text-sm font-medium text-gray-700">
                                Mot de passe
                            </label>
                            <div class="relative">
                                <x-text-input id="password" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-purple-500 focus:ring-0 transition-colors duration-200 bg-gray-50 focus:bg-white" type="password" name="password" required autocomplete="new-password" />
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                    </svg>
                                </div>
                            </div>
                            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-600 text-sm" />
                        </div>

                        <!-- Confirm Password -->
                        <div class="space-y-2">
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">
                                Confirmer le mot de passe
                            </label>
                            <div class="relative">
                                <x-text-input id="password_confirmation" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-purple-500 focus:ring-0 transition-colors duration-200 bg-gray-50 focus:bg-white" type="password" name="password_confirmation" required autocomplete="new-password" />
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                    </svg>
                                </div>
                            </div>
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-600 text-sm" />
                        </div>

                        <button type="submit" 
                                class="w-full bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white font-semibold py-3 px-6 rounded-xl transition-all duration-200 transform hover:scale-[1.02] hover:shadow-lg focus:outline-none focus:ring-4 focus:ring-purple-300">
                            {{ __('Enregistrer') }}
                        </button>

                        <div class="text-center">
                            <a class="text-sm text-purple-600 hover:text-purple-800 font-medium transition-colors duration-200 border-b border-transparent hover:border-purple-600" href="{{ route('login') }}">
                                {{ __('Déjà inscrit ?') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Animations personnalisées */
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        
        .animate-float {
            animation: float 3s ease-in-out infinite;
        }
        
        /* Effet de focus amélioré */
        input:focus {
            box-shadow: 0 0 0 3px rgba(168, 85, 247, 0.1);
        }
        
        /* Transition douce pour les boutons */
        button:active {
            transform: scale(0.98);
        }
    </style>
</x-guest-layout>