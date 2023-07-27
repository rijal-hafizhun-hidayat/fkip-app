<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DetailMahasiswa from './Partials/DetailMahasiswa.vue'
import { Head } from '@inertiajs/vue3';
import Table from './Partials/Table.vue';
import ModalCreateBimbingan from './Partials/ModalCreateBimbingan.vue'

const props = defineProps({
    id: Number
})

console.log(props.id)
</script>
<template>
    <Head title="Dpl" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <div><h2 class="font-semibold text-xl text-gray-800 leading-tight">Bimbingan Mahasiswa</h2></div>
                <!-- <div><PrimaryButton class="order-1 mt-[-10px]">Tambah Kelas</PrimaryButton></div> -->
                <div class="order-1"><ModalCreateBimbingan :id="id"/></div>
            </div>
        </template>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <DetailMahasiswa :id="id"/>
            <Table :id="id"/>
        </div>
    </AuthenticatedLayout>
</template>
