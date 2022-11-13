<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gérer') }}
        </h2>
    </x-slot>
    <div class="py-12 p-4" x-data="{ open: false }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex mb-4 justify-end">
                <x-link href="{{ route('budget.create') }}">
                    {{ __('Créer une nouvelle période') }}
                </x-link>
            </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4" x-show="open">
            <div class="p-6 bg-white border-b border-gray-200 text-lg">
                <span class="text-lg font-bold">Ajouter une dépense</span>
                <div class="flex flex-col mt-4">
                    @if ($period)
                        <form method="POST" action="{{ route('debit.store') }}">
                            @csrf

                            <!-- Date Début -->
                            <div class="flex justify-center ">
                                <select name="category_id" class="form-select appearance-none
                                block
                                w-full
                                px-3
                                py-1.5
                                text-base
                                font-normal
                                text-gray-700
                                bg-white bg-clip-padding bg-no-repeat
                                border border-solid border-gray-300
                                rounded
                                transition
                                ease-in-out
                                m-0
                                focus:text-gray-700 focus:bg-white focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" aria-label="Default select example">
                                    <option selected disabled>Categorie</option>
                                    @forelse ($period->categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @empty
                                        <option>Aucune Catégorie</option>
                                    @endforelse
                                </select>
                            </div>

                            <!-- Date Fin -->
                            <div class="mt-4">
                                <x-input-label for="amount" :value="__('Prix')" />

                                <x-text-input id="amount" class="block mt-1 w-full" type="number" name="amount" :value="old('amount')" />

                                <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                            </div>

                            <div class="flex justify-center mt-2">
                                <x-primary-button>
                                    {{ __('Valider') }}
                                </x-primary-button>
                            </div>
                        </form>
                    @else
                        Ajouter une période
                    @endif
                </div>
            </div>
        </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 text-lg">
                    @if ($period)
                        <div class="flex items-center">
                            Période en cours du <span class="font-bold"> {{ Carbon\Carbon::parse($period->started_at)->format('d/m/Y') }} </span> au <span class="font-bold"> {{ Carbon\Carbon::parse($period->ended_at)->format('d/m/Y') }}</span>
                            <a href="{{ route('budget.edit', $period->id) }}">
                                <svg class="h-4 w-4 ml-2 hover:text-teal-500" <svg  width="24"  height="24"  viewBox="0 0 24 24"  xmlns="http://www.w3.org/2000/svg"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />  <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" /></svg>
                            </a>
                        </div>
                        <div class="flex flex-col mt-4">
                            <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                                <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
                                    <div class="overflow-hidden">
                                        <table class="min-w-full text-base">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th class="py-2">Nom</th>
                                                    <th class="py-2">Prévu</th>
                                                    <th class="py-2">Objectif</th>
                                                    <th class="py-2">Dépense Réel</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($period->categories as $category)
                                                    <tr class="border-t-2 border-gray-100">
                                                        <td class="py-2 text-center">{{ $category->name }}</td>
                                                        <td class="py-2 text-center">{{ $category->spending }}</td>
                                                        <td class="py-2 text-center">{{ $category->objective }}</td>
                                                        <td class="py-2 text-center">{{ $category->real }}</td>
                                                    </tr>
                                                @empty
                                                    Ajouter des catégories
                                                @endforelse
                                            </tbody>
                                            <tfoot>
                                                <tr class="border-t border-gray-200">
                                                    <td></td>
                                                    <td></td>
                                                    <td class="py-2 font-semibold text-right">Solde de départ</td>
                                                    <td class="py-2 flex justify-end">{{ $period->budget }} €</td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td class="py-2 font-semibold text-right">Solde prévu au {{ Carbon\Carbon::parse($period->ended_at)->format('d/m/Y')  }}</td>
                                                    <td class="py-2 flex justify-end">{{ $period->previsionnel() }} €</td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td class="py-2 font-semibold text-right">Solde prévu avec objectif au {{ Carbon\Carbon::parse($period->ended_at)->format('d/m/Y')  }}</td>
                                                    <td class="py-2 flex justify-end">{{ $period->objective() }} €</td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td class="py-2 font-bold text-right">Solde Réel au {{ Carbon\Carbon::parse(Carbon\Carbon::now())->format('d/m/Y')  }}</td>
                                                    <td class="py-2 flex justify-end font-bold">
                                                        @if ($period->real() < $period->objective())
                                                            <span class="text-red-500">{{ $period->real() }} €</span>
                                                        @elseif ($period->real() < $period->previsionnel())
                                                            <span class="text-orange-500">{{ $period->real() }} €</span>
                                                        @else
                                                            <span class="text-green-500">{{ $period->real() }} €</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-center mt-4">
                            <x-link x-on:click="open = ! open">
                                {{ __('Ajouter une dépense') }}
                            </x-link>
                        </div>
                    @else
                        Commencer à créer une période
                    @endif
                </div>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-4">
                <div class="p-6 bg-white border-b border-gray-200 text-lg">
                    <span class="font-bold">Liste des dépenses :</span>
                    <div class="mt-2">
                        <ul class="list-disc p-4">
                            @foreach ($debits as $item)
                                <li>{{ $item->category->name }} : - {{ $item->amount }} € <span class="text-xs">Le {{ Carbon\Carbon::parse($item->created_at)->format('d/m/Y')  }}</span></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
