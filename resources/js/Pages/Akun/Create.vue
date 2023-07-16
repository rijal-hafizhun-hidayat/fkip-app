<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import FormCreate from './partials/FormCreate.vue';

const props = defineProps({
    guruPamongs: Object,
    prodis: Object,
    dpls: Object,
    mahasiswas: Object
})
</script>
<template>
    <Head title="Tambah Akun" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <div><h2 class="font-semibold text-xl text-gray-800 leading-tight">Tambah Akun</h2></div>
            </div>
        </template>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white py-8 px-10 mt-10 rounded-md shadow-md">
                <FormCreate :guruPamongs="guruPamongs" :prodis="prodis" :dpls="dpls" :mahasiswas="mahasiswas"/>
            </div>
        </div>
    </AuthenticatedLayout>
</template>