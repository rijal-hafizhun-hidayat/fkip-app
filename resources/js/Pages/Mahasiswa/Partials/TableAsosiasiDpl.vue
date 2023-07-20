<script setup>
import axios from 'axios';
import { onMounted, reactive, ref } from 'vue'
import DestroyButton from '@/Components/DestroyButton.vue';
import Swal from 'sweetalert2';
import { router } from '@inertiajs/vue3'

const dpl = reactive({
    id: '',
    nipy: '',
    nama: '',
    email: '',
    prodi: '',
    length: '',
})
const props = defineProps({
    id: Number,
    user: Array,
    idDpl: Number
})

onMounted(() => {
    getDplById()
})

const getDplById = () => {
    axios.get(`/getDplMahasiswaById/${props.id}`)
    .then((res) => {
        dpl.nipy = res.data.data[0].nipy
        dpl.nama = res.data.data[0].nama
        dpl.email = res.data.data[0].email
        dpl.prodi = res.data.data[0].prodi
        dpl.length = res.data.data.length
    })
    .catch((err) => {
        console.log(err)
    })
}

const destroyDpl = (id) => {
    axios.delete(`/destroyAsosiasiDpl/${id}`)
    .then((res) => {
        Swal.fire({
            icon: 'success',
            title: res.data.title,
            text: res.data.text
        })
        router.get(`/mahasiswa/dpl/${id}`)
    })
    .catch((err) => {
        console.log(err)
    })
}
</script>
<template>
    <div class="bg-white rounded-md shadow overflow-x-auto mt-10">
        <table class="w-full whitespace-nowrap">
            <thead>
                <tr class="text-left font-bold">
                    <th class="pb-4 pt-6 px-6">Nip / Niy</th>
                    <th class="pb-4 pt-6 px-6">Nama</th>
                    <th class="pb-4 pt-6 px-6">Email</th>
                    <th class="pb-4 pt-6 px-6">Prodi</th>
                    <th v-if="user.role == 1" class="pb-4 pt-6 px-6">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-if="dpl.length == 1" class="hover:bg-gray-100">
                    <td class="border-t items-center px-6 py-4">
                        {{ dpl.nipy }}
                    </td>
                    <td class="border-t items-center px-6 py-4">
                        {{ dpl.nama }}
                    </td>
                    <td class="border-t items-center px-6 py-4">
                        {{ dpl.email }}
                    </td>
                    <td class="border-t items-center px-6 py-4">
                        {{ dpl.prodi }}
                    </td>
                    <td v-if="user.role == 1" class="border-t items-center px-6 py-4">
                        <div class="flex flex-row space-x-4">
                            <DestroyButton @click="destroyDpl(id)"><i class="fa-solid fa-trash text-white"></i></DestroyButton>
                        </div>
                    </td>
                </tr>
                <tr v-else>
                    <td class="px-6 py-4 text-center border-t" colspan="5">No data found.</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>