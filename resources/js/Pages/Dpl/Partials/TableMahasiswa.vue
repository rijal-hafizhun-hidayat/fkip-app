<script setup>
import { onMounted, ref } from 'vue';
import axios from 'axios';
import DestroyButton from '@/Components/DestroyButton.vue';
import Swal from 'sweetalert2';
import { router } from '@inertiajs/vue3'

const mahasiswas = ref([])
const props = defineProps({
    id: Number
})

onMounted(() => {
    getMahasiswaBimbinganByIdDpl()
})

const getMahasiswaBimbinganByIdDpl = () => {
    axios.get(`/getMahasiswaBimbinganByIdDpl/${props.id}`)
    .then((res) => {
        mahasiswas.value = res.data.data
    })
    .catch((err) => {
        console.log(err)
    })
}

const destroy = (id) => {
    axios.delete(`/destroyAsosiasiDpl/${id}`)
    .then((res) => {
        Swal.fire({
            icon: 'success',
            title: res.data.title,
            text: res.data.text
        })
        router.get(`/dpl/asosiasi/${props.id}`)
    })
    .catch((err) => {
        console.log(err)
    })
}
</script>
<template>
    <div class="bg-white rounded-md shadow-md overflow-x-auto mt-10">
        <p class="font-semibold text-xl text-gray-800 leading-tight ms-5 mt-5 mb-5">Data Bimbingan Mahasiswa</p>
        <hr>
        <table class="w-full whitespace-nowrap">
            <thead>
                <tr class="text-left font-bold">
                    <th class="pb-4 pt-6 px-6">Nim</th>
                    <th class="pb-4 pt-6 px-6">Nama</th>
                    <th class="pb-4 pt-6 px-6">Prodi</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="mahasiswa in mahasiswas" :key="mahasiswa.id" class="hover:bg-gray-100">
                    <td class="border-t items-center px-6 py-4">
                        {{ mahasiswa.nim }}
                    </td>
                    <td class="border-t items-center px-6 py-4">
                        {{ mahasiswa.nama }}
                    </td>
                    <td class="border-t items-center px-6 py-4">
                        {{ mahasiswa.prodi }}
                    </td>
                </tr>
                <tr v-if="mahasiswas.length == 0">
                    <td class="px-6 py-4 text-center border-t" colspan="3">No data found.</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>