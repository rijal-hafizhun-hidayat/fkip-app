<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import FormAddGuruPamongMahasiswa from './Partials/FormAddGuruPamongMahasiswa.vue';
import TableGuruPamong from './Partials/TableGuruPamong.vue';
import TableMahasiswa from './Partials/TableMahasiswa.vue'
defineProps({
    id: Number
})
</script>
<template>
    <Head title="Tambah Asosiasi Guru Pamong" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <div><h2 class="font-semibold text-xl text-gray-800 leading-tight">Tambah Asosiasi DPL</h2></div>
            </div>
        </template>

        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white py-8 px-10 mt-10 rounded-md shadow-md">
                <FormAddGuruPamongMahasiswa :id="id" />
            </div>
            <TableGuruPamong :id="id"/>
            <TableMahasiswa :id="id" />
        </div>
    </AuthenticatedLayout>
</template>
