<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import FormCreate from './Partials/FormCreate.vue';
import FormImport from './Partials/FormImport.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { ref } from 'vue'

const isClick= ref(false);
const clickForm = (isBool) => {
    isClick.value = isBool
}
</script>
<template>
    <Head title="Tambah Sekolah" />
    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <div><h2 class="font-semibold text-xl text-gray-800 leading-tight">Tambah Sekolah</h2></div>
                <!-- <div><PrimaryButton class="order-1 mt-[-10px]">Tambah Kelas</PrimaryButton></div> -->
            </div>
        </template>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white py-5 px-10 mt-10 rounded-md shadow-md">
                <div class="space-x-4">
                    <PrimaryButton @click="clickForm(false)">Manual</PrimaryButton>
                    <PrimaryButton @click="clickForm(true)">Import</PrimaryButton>
                </div>
                <FormCreate v-if="!isClick" />
                <FormImport v-if="isClick" />
            </div>
        </div>
    </AuthenticatedLayout>
</template>