<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Créer une nouvelle période') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('budget.store') }}">
                        @csrf

                        <!-- Date Début -->
                        <div>
                            <x-input-label for="budget" :value="__('Budget initial')" />

                            <x-text-input id="budget" class="block mt-1 w-full" type="number" name="budget" :value="old('budget')" autofocus />

                            <x-input-error :messages="$errors->get('budget')" class="mt-2" />
                        </div>
                        <!-- Date Début -->
                        <div class="mt-4">
                            <x-input-label for="started_at" :value="__('Date de départ')" />

                            <x-text-input id="started_at" class="block mt-1 w-full" type="date" name="started_at" :value="old('started_at')" />

                            <x-input-error :messages="$errors->get('started_at')" class="mt-2" />
                        </div>

                        <!-- Date Fin -->
                        <div class="mt-4">
                            <x-input-label for="ended_at" :value="__('Date de fin')" />

                            <x-text-input id="ended_at" class="block mt-1 w-full" type="date" name="ended_at" :value="old('ended_at')" />

                            <x-input-error :messages="$errors->get('ended_at')" class="mt-2" />
                        </div>


                        <div class="flex flex-col mt-4" x-data="handler()">
                            <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                                <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
                                    <div class="overflow-hidden">
                                        <table class="min-w-full">
                                            <thead class="thead-light">
                                            <tr>
                                                <th>Nom</th>
                                                <th>Dépense</th>
                                                <th>Objectif</th>
                                                <th>Couleur</th>
                                                <th>Remove</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <template x-for="(field, index) in fields" :key="index">
                                                    <tr>
                                                        <td class="px-2"><x-text-input x-model="field.name" class="block mt-1 w-full" type="text" name="name[]" :value="old('namme')" required/></td>
                                                        <td class="px-2"><x-text-input x-model="field.spending" class="block mt-1 w-full" type="text" name="spending[]" :value="old('spending')" required/></td>
                                                        <td class="px-2"><x-text-input x-model="field.objective" class="block mt-1 w-full" type="text" name="objective[]" :value="old('objective')" required/></td>
                                                        <td class="px-2"><x-text-input x-model="field.color" class="block mt-1 w-full" type="color" name="color[]" :value="old('color')" required/></td>
                                                        <td class="text-center">
                                                            <x-link @click="removeField(index)">
                                                                &times;
                                                            </x-link>
                                                        </td>
                                                    </tr>
                                                </template>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="5" class="text-right">
                                                        <x-link @click="addNewField()" class="mt-4">
                                                            + Add Row
                                                        </x-link>
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-center mt-4">
                            <x-primary-button>
                                {{ __('Valider') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function handler() {
    return {
        fields: [],
        addNewField() {
            this.fields.push({
                name: '',
                spending: '',
                objective: '',
                color: '',
            });
            },
            removeField(index) {
            this.fields.splice(index, 1);
            }
    }
 }
    </script>
</x-app-layout>
