<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import FormUpdate from './Partials/FormUpdate.vue';

defineProps({
    id: Number
})
</script>
<template>
    <Head title="Edit Sekolah" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <div><h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Sekolah</h2></div>
                <!-- <div><PrimaryButton class="order-1 mt-[-10px]">Tambah Kelas</PrimaryButton></div> -->
            </div>
        </template>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white py-5 px-10 mt-10 rounded-md shadow-md">
                <FormUpdate :id="id" />
            </div>
        </div>
    </AuthenticatedLayout>
</template>