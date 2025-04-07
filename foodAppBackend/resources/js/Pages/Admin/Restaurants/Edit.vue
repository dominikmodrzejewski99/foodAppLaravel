<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps({
    restaurant: Object,
});

const form = useForm({
    name: props.restaurant.name,
    address: props.restaurant.address,
    city: props.restaurant.city,
    cuisine: props.restaurant.cuisine,
    rating: props.restaurant.rating,
    website: props.restaurant.website,
    match_people_count: props.restaurant.match_people_count,
    match_price_per_person: props.restaurant.match_price_per_person,
    match_meal_type: props.restaurant.match_meal_type,
    match_visit_purpose: props.restaurant.match_visit_purpose,
    match_dietary_preferences: props.restaurant.match_dietary_preferences,
});

const submit = () => {
    form.put(route('admin.restaurants.update', props.restaurant.id));
};
</script>

<template>
    <Head title="Edytuj Restaurację" />

    <AppLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Edytuj Restaurację
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <form @submit.prevent="submit">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Podstawowe informacje -->
                            <div class="space-y-4">
                                <div>
                                    <InputLabel for="name" value="Nazwa" />
                                    <TextInput
                                        id="name"
                                        v-model="form.name"
                                        type="text"
                                        class="mt-1 block w-full"
                                        required
                                    />
                                    <InputError :message="form.errors.name" class="mt-2" />
                                </div>

                                <div>
                                    <InputLabel for="address" value="Adres" />
                                    <TextInput
                                        id="address"
                                        v-model="form.address"
                                        type="text"
                                        class="mt-1 block w-full"
                                        required
                                    />
                                    <InputError :message="form.errors.address" class="mt-2" />
                                </div>

                                <div>
                                    <InputLabel for="city" value="Miasto" />
                                    <TextInput
                                        id="city"
                                        v-model="form.city"
                                        type="text"
                                        class="mt-1 block w-full"
                                        required
                                    />
                                    <InputError :message="form.errors.city" class="mt-2" />
                                </div>

                                <div>
                                    <InputLabel for="cuisine" value="Kuchnia" />
                                    <TextInput
                                        id="cuisine"
                                        v-model="form.cuisine"
                                        type="text"
                                        class="mt-1 block w-full"
                                        required
                                    />
                                    <InputError :message="form.errors.cuisine" class="mt-2" />
                                </div>

                                <div>
                                    <InputLabel for="rating" value="Ocena (0-5)" />
                                    <TextInput
                                        id="rating"
                                        v-model="form.rating"
                                        type="number"
                                        step="0.1"
                                        min="0"
                                        max="5"
                                        class="mt-1 block w-full"
                                    />
                                    <InputError :message="form.errors.rating" class="mt-2" />
                                </div>

                                <div>
                                    <InputLabel for="website" value="Strona internetowa" />
                                    <TextInput
                                        id="website"
                                        v-model="form.website"
                                        type="text"
                                        class="mt-1 block w-full"
                                    />
                                    <InputError :message="form.errors.website" class="mt-2" />
                                </div>
                            </div>

                            <!-- Wartości dopasowania -->
                            <div class="space-y-4">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Wartości dopasowania (0-9)</h3>
                                
                                <div>
                                    <InputLabel for="match_people_count" value="Dopasowanie do ilości osób" />
                                    <div class="flex items-center mt-1">
                                        <input
                                            id="match_people_count"
                                            v-model="form.match_people_count"
                                            type="range"
                                            min="0"
                                            max="9"
                                            class="w-full"
                                        />
                                        <span class="ml-2 text-gray-700 dark:text-gray-300">{{ form.match_people_count }}</span>
                                    </div>
                                    <InputError :message="form.errors.match_people_count" class="mt-2" />
                                </div>

                                <div>
                                    <InputLabel for="match_price_per_person" value="Dopasowanie do ceny na osobę" />
                                    <div class="flex items-center mt-1">
                                        <input
                                            id="match_price_per_person"
                                            v-model="form.match_price_per_person"
                                            type="range"
                                            min="0"
                                            max="9"
                                            class="w-full"
                                        />
                                        <span class="ml-2 text-gray-700 dark:text-gray-300">{{ form.match_price_per_person }}</span>
                                    </div>
                                    <InputError :message="form.errors.match_price_per_person" class="mt-2" />
                                </div>

                                <div>
                                    <InputLabel for="match_meal_type" value="Dopasowanie do rodzaju posiłku" />
                                    <div class="flex items-center mt-1">
                                        <input
                                            id="match_meal_type"
                                            v-model="form.match_meal_type"
                                            type="range"
                                            min="0"
                                            max="9"
                                            class="w-full"
                                        />
                                        <span class="ml-2 text-gray-700 dark:text-gray-300">{{ form.match_meal_type }}</span>
                                    </div>
                                    <InputError :message="form.errors.match_meal_type" class="mt-2" />
                                </div>

                                <div>
                                    <InputLabel for="match_visit_purpose" value="Dopasowanie do celu wizyty" />
                                    <div class="flex items-center mt-1">
                                        <input
                                            id="match_visit_purpose"
                                            v-model="form.match_visit_purpose"
                                            type="range"
                                            min="0"
                                            max="9"
                                            class="w-full"
                                        />
                                        <span class="ml-2 text-gray-700 dark:text-gray-300">{{ form.match_visit_purpose }}</span>
                                    </div>
                                    <InputError :message="form.errors.match_visit_purpose" class="mt-2" />
                                </div>

                                <div>
                                    <InputLabel for="match_dietary_preferences" value="Dopasowanie do preferencji dietetycznych" />
                                    <div class="flex items-center mt-1">
                                        <input
                                            id="match_dietary_preferences"
                                            v-model="form.match_dietary_preferences"
                                            type="range"
                                            min="0"
                                            max="9"
                                            class="w-full"
                                        />
                                        <span class="ml-2 text-gray-700 dark:text-gray-300">{{ form.match_dietary_preferences }}</span>
                                    </div>
                                    <InputError :message="form.errors.match_dietary_preferences" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <PrimaryButton class="ml-4" :disabled="form.processing">
                                Zapisz zmiany
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
