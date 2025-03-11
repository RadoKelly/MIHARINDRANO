@extends('layouts.app')
@section('navbar')
    @include('navbar')
@endsection
@section('content')
    <div class="container mx-auto px-4 sm:px-6 md:px-8 py-8 ml-16">
        <!-- Flex container for heading and button -->
        <div class="flex flex-col sm:flex-row justify-between items-center mb-6">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Relevé consommations clients</h1>
            <div class="flex mt-4 sm:mt-0 space-x-3">
                <a href="{{ route('tarifs.index', ['site' => $site->id]) }}"
                    class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 mt-4 sm:mt-0"
                    aria-label="Ajouter un Relevé">
                    Tarifs
                </a>
                <a href="#"
                    class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 mt-4 sm:mt-0"
                    aria-label="Ajouter un Relevé">
                    Ajouter un Relevé
                </a>
                
            </div>
        </div>

        <!-- Responsive table container -->
        <div class="overflow-x-auto">
            <table class="w-full table-auto border-collapse">
                <thead class="bg-blue-900 text-white">
                    <tr>
                        <th
                            class="p-2 sm:p-3 text-center text-xs sm:text-sm font-medium uppercase tracking-wider truncate border border-blue-800">
                            N° Référence</th>
                        <th
                            class="p-2 sm:p-3 text-center text-xs sm:text-sm font-medium uppercase tracking-wider truncate border border-blue-800">
                            Nom client</th>
                        <th
                            class="p-2 sm:p-3 text-center text-xs sm:text-sm font-medium uppercase tracking-wider truncate border border-blue-800">
                            Date du relevé</th>
                        <th
                            class="p-2 sm:p-3 text-center text-xs sm:text-sm font-medium uppercase tracking-wider truncate border border-blue-800">
                            Ancienne date</th>
                        <th
                            class="p-2 sm:p-3 text-center text-xs sm:text-sm font-medium uppercase tracking-wider truncate border border-blue-800">
                            N° facture</th>
                        <th
                            class="p-2 sm:p-3 text-center text-xs sm:text-sm font-medium uppercase tracking-wider truncate border border-blue-800">
                            Tarif</th>
                        <th
                            class="p-2 sm:p-3 text-center text-xs sm:text-sm font-medium uppercase tracking-wider truncate border border-blue-800">
                            Ancien index</th>
                        <th
                            class="p-2 sm:p-3 text-center text-xs sm:text-sm font-medium uppercase tracking-wider truncate border border-blue-800">
                            Nouvel index</th>
                        <th
                            class="p-2 sm:p-3 text-center text-xs sm:text-sm font-medium uppercase tracking-wider truncate border border-blue-800">
                            Consommation</th>
                        <th
                            class="p-2 sm:p-3 text-center text-xs sm:text-sm font-medium uppercase tracking-wider truncate border border-blue-800">
                            Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <tr class="hover:bg-gray-50 transition duration-300 border">
                        <td class="p-2 sm:p-3 text-sm text-gray-700 truncate overflow-hidden border relative">
                            <span>REF001</span>
                            <div class="absolute inset-y-0 right-0 flex items-center">
                                <button class="text-gray-500 hover:text-gray-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                        <td class="p-2 sm:p-3 text-sm text-gray-700 truncate overflow-hidden border">Client Exemple</td>

                        <td class="p-2 sm:p-3 text-sm text-gray-700 truncate overflow-hidden border bg-blue-100 relative">
                            <span>01/02/2025</span>
                            <div class="absolute inset-y-0 right-0 flex items-center">
                                <button class="text-gray-500 hover:text-gray-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                        <td class="p-2 sm:p-3 text-sm text-gray-700 truncate overflow-hidden border"></td>

                        <td class="p-2 sm:p-3 text-sm text-gray-700 truncate overflow-hidden border">FT202501</td>
                        <td class="p-2 sm:p-3 text-sm text-gray-700 truncate overflow-hidden border">2500</td>
                        <td class="p-2 sm:p-3 text-sm text-gray-700 truncate overflow-hidden border relative">
                            <span>0,00</span>
                            <div class="absolute inset-y-0 right-0 flex items-center">
                                <button class="text-gray-500 hover:text-gray-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                        <td class="p-2 sm:p-3 text-sm text-gray-700 truncate overflow-hidden border relative">
                            <span>10,00</span>
                            <div class="absolute inset-y-0 right-0 flex items-center">
                                <button class="text-gray-500 hover:text-gray-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                        <td class="p-2 sm:p-3 text-sm text-gray-700 truncate overflow-hidden border">10,00</td>
                        <td class="p-2 sm:p-3 text-sm border">
                            <div class="flex flex-wrap justify-center">
                                <a href="#" class="text-yellow-500 hover:text-yellow-700 mr-2 py-1 px-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                                <button type="button" class="text-red-500 hover:text-red-700 py-1 px-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <!-- Vous pouvez copier cette ligne et modifier les données pour avoir plusieurs lignes -->
                </tbody>
            </table>
        </div>
    </div>
@endsection
