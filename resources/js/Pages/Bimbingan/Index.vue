<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DetailMahasiswa from './Partials/DetailMahasiswa.vue'
import { Head, usePage } from '@inertiajs/vue3';
import Table from './Partials/Table.vue';
import ModalCreateBimbingan from './Partials/ModalCreateBimbingan.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { computed } from 'vue'
import axios from 'axios';

const page = usePage()
const user = computed(() => page.props.auth.user)
const props = defineProps({
    id: Number
})

const printPdf = () => {
    axios.get(`/bimbingan/print/${props.id}`, {
        responseType: 'blob',
    })
    .then((res) => {
        console.log(res)
    })
    .catch((err) => {
        console.log(err)
    })
}
</script>
<template>
    <Head title="Dpl" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <div><h2 class="font-semibold text-xl text-gray-800 leading-tight">Bimbingan Mahasiswa</h2></div>
                <!-- <div><PrimaryButton class="order-1 mt-[-10px]">Tambah Kelas</PrimaryButton></div> -->
                <div class="flex justify-end space-x-4">
                    <div @click="printPdf()"><PrimaryButton>Cetak Bimbingan</PrimaryButton></div>
                    <div v-if="user.role == 4 || user.role == 2"><ModalCreateBimbingan :id="id"/></div>
                </div>
            </div>
        </template>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <DetailMahasiswa :id="id"/>
            <Table :id="id" :user="user"/>
        </div>
    </AuthenticatedLayout>
</template>
