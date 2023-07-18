<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DetailMahasiswa from './Partials/DetailMahasiswa.vue'
import { Head } from '@inertiajs/vue3';
import Table from './Partials/Table.vue';
import { ref, onMounted, reactive } from 'vue';
import axios from 'axios';

const mahasiswa = reactive({
    nim: '',
    nama: ''
})
const props = defineProps({
    id: Number
})

onMounted(() => {
    getMahasiswaById()
})

const getMahasiswaById = () => {
    axios.get(`/getMahasiswaById/${props.id}`)
    .then((res) => {
        mahasiswa.nim = res.data.data.nim
        mahasiswa.nama = res.data.data.nama
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
                <div class="order-1"><PrimaryButton @click="create">Tambah Bimbingan</PrimaryButton></div>
            </div>
        </template>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <DetailMahasiswa :mahasiswa="mahasiswa"/>
            <Table />
        </div>
    </AuthenticatedLayout>
</template>
