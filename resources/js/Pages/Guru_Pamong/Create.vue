<script setup>
import { ref } from 'vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import FormCreate from './Partials/FormCreate.vue';
import FormImport from './Partials/FormImport.vue';

const isClick= ref(false);
defineProps({
    sekolahs: Object
})
const clickForm = (isBool) => {
    isClick.value = isBool
}
</script>
<template>
    <Head title="Tambah Guru Pamong" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <div><h2 class="font-semibold text-xl text-gray-800 leading-tight">Tambah Guru Pamong</h2></div>
            </div>
        </template>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white py-8 px-10 mt-10 rounded-md shadow-md">
                <div class="space-x-4">
                    <PrimaryButton @click="clickForm(false)">Manual</PrimaryButton>
                    <PrimaryButton @click="clickForm(true)">Import</PrimaryButton>
                </div>
                <hr class="mt-5 bg-black">
                <FormCreate v-if="!isClick" :sekolahs="sekolahs" />
                <FormImport v-if="isClick"/>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
