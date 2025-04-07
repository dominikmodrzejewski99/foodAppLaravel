<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Components/Welcome.vue';
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <div class="mb-8 text-center">
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-6">Panel Administracyjny</h3>
                        <a href="/admin/restaurants" class="inline-flex items-center px-6 py-3 bg-red-600 border border-transparent rounded-md font-semibold text-base text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Zarządzanie Restauracjami
                        </a>
                        <p class="mt-4 text-gray-600 dark:text-gray-400">Kliknij powyższy przycisk, aby przejść do panelu zarządzania restauracjami</p>
                    </div>
                    <Welcome />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
