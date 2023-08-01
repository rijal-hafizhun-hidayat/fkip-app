<script setup>
import { onMounted, ref } from 'vue';
import axios from 'axios';
import DestroyButton from '@/Components/DestroyButton.vue';

const mahasiswas = ref([])
const props = defineProps({
    id: Number
})

onMounted(() => {
    getMahasiswaByIdDpl()
})

const getMahasiswaByIdDpl = () => {
    axios.get(`/getMahasiswaByIdDpl/${props.id}`)
    .then((res) => {
        console.log(res)
        mahasiswas.value = res.data.data
    })
    .catch((err) => {
        console.log(err)
    })
}

const destroy = (id) => {
    axios.delete(`/destroyAsosiasiDpl/${id}`)
    .then((res) => {
        console.log(res)
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
                    <th class="pb-4 pt-6 px-6">Nama</th>
                    <th class="pb-4 pt-6 px-6">Prodi</th>
                    <th class="pb-4 pt-6 px-6">Email</th>
                    <th class="pb-4 pt-6 px-6">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="mahasiswa in mahasiswas" :key="mahasiswa.id" class="hover:bg-gray-100">
                    <td class="border-t items-center px-6 py-4">
                        {{ mahasiswa.nama }}
                    </td>
                    <td class="border-t items-center px-6 py-4">
                        {{ mahasiswa.prodi }}
                    </td>
                    <td class="border-t items-center px-6 py-4">
                        {{ mahasiswa.email }}
                    </td>
                    <td class="border-t items-center px-6 py-4">
                        <div class="flex flex-row space-x-4">
                            <DestroyButton @click="destroy(mahasiswa.id)"><i class="fa-solid fa-trash text-white"></i></DestroyButton>
                        </div>
                    </td>
                </tr>
                <tr v-if="mahasiswas.length === 0">
                    <td class="px-6 py-4 text-center border-t" colspan="4">No data found.</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>