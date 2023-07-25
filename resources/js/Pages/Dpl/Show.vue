<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import FormUpdate from './Partials/FormUpdate.vue';

const props = defineProps({
    prodis: Object,
    dpls: Object,
    id: Number
})
</script>
<template>
    <Head title="Ubah Dpl" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <div><h2 class="font-semibold text-xl text-gray-800 leading-tight">Ubah Dpl</h2></div>
            </div>
        </template>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white py-8 px-10 mt-10 rounded-md shadow-md">
                <FormUpdate :prodis="prodis" :dpls="dpls" :id="id"/>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
