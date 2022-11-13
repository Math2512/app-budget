<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Modifier la période') }} <span class="font-bold">{{ Carbon\Carbon::parse($period->started_at)->format('d/m/Y') }}</span> au <span class="font-bold">{{ Carbon\Carbon::parse($period->ended_at)->format('d/m/Y') }}</span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('budget.update', $period->id) }}">
                        @method('PUT')
                        @csrf

                        <!-- Date Début -->
                        <div>
                            <x-input-label for="budget" :value="__('Budget initial')" />

                            <x-text-input id="budget" class="block mt-1 w-full" type="number" name="budget" value="{{ $period->budget }}" required autofocus />

                            <x-input-error :messages="$errors->get('budget')" class="mt-2" />
                        </div>
                        <!-- Date Début -->
                        <div>
                            <x-input-label for="started_at" :value="__('Date de départ')" />

                            <x-text-input id="started_at" class="block mt-1 w-full" type="date" name="started_at" value="{{$period->started_at}}" required />

                            <x-input-error :messages="$errors->get('started_at')" class="mt-2" />
                        </div>

                        <!-- Date Fin -->
                        <div class="mt-4">
                            <x-input-label for="ended_at" :value="__('Date de fin')" />

                            <x-text-input id="ended_at" class="block mt-1 w-full" type="date" name="ended_at" value="{{$period->ended_at}}" required />

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
                                                @foreach ($period->categories as $category)
                                                    <tr>
                                                        <td class="px-2"><x-text-input class="block mt-1 w-full" type="text" name="existing_name[{{$category->id}}]" value="{{$category->name}}" /></td>
                                                        <td class="px-2"><x-text-input class="block mt-1 w-full" type="text" name="existing_spending[{{$category->id}}]" value="{{$category->spending}}" /></td>
                                                        <td class="px-2"><x-text-input class="block mt-1 w-full" type="text" name="existing_objective[{{$category->id}}]" value="{{$category->objective}}" /></td>
                                                        <td class="px-2"><x-text-input class="block mt-1 w-full" type="color" name="existing_color[{{$category->id}}]" value="{{$category->color}}" /></td>
                                                        <td class="text-center">
                                                            <x-link @click="removeField(index)">
                                                                &times;
                                                            </x-link>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                <template x-for="(field, index) in fields" :key="index">
                                                    <tr>
                                                        <td class="px-2"><x-text-input x-model="field.name" class="block mt-1 w-full" type="text" name="name[]" :value="old('namme')" /></td>
                                                        <td class="px-2"><x-text-input x-model="field.spending" class="block mt-1 w-full" type="text" name="spending[]" :value="old('spending')" /></td>
                                                        <td class="px-2"><x-text-input x-model="field.objective" class="block mt-1 w-full" type="text" name="objective[]" :value="old('objective')" /></td>
                                                        <td class="px-2"><x-text-input x-model="field.color" class="block mt-1 w-full" type="color" name="color[]" :value="old('color')" /></td>
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
                                {{ __('Modifier') }}
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
