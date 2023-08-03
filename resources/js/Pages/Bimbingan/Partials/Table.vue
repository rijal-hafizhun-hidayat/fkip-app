<script setup>
import axios from 'axios';
import { onMounted, ref } from 'vue'
import DestroyButton from '@/Components/DestroyButton.vue';
import ModalUpdateBimbingan from './ModalUpdateBimbingan.vue';
import GoogleDriveButton from '@/Components/GoogleDriveButton.vue';
import StatusConfirm from '@/Components/StatusConfirm.vue';
import DetailButton from '@/Components/DetailButton.vue';
import ModalCreateCatatanPembimbing from './ModalCreateCatatanPembimbing.vue';
import moment from 'moment';
import Swal from 'sweetalert2';
import { router } from '@inertiajs/vue3'

const bimbingans = ref([])
const props = defineProps({
    id: Number,
    user: Array
})

onMounted(() => {
    moment.locale('id')
    getBimbinganByIdMahasiswa()
})

const getBimbinganByIdMahasiswa = () => {
    axios.get(`/getBimbinganByIdMahasiswa/${props.id}`)
    .then((res) => {
        console.log(res)
        bimbingans.value = res.data.data
    })
    .catch((err) => {
        console.log(err)
    })
}

const destroy = (id) => {
    axios.delete(`/bimbingans/${id}`)
    .then((res) => {
        Swal.fire({
            icon: 'success',
            title: res.data.title,
            text: res.data.text
        })
        router.get(`/bimbingans/${props.id}`)
    })
    .catch((err) => {
        Swal.fire({
            icon: 'error',
            title: err.response.data.title,
            text: err.response.data.text
        })
        router.get(`/bimbingans/${props.id}`)
    })
}

const confirmed = (id) => {
    axios.put(`/bimbingan/confirmed/${id}`, {
        confirmed: 1  
    })
    .then((res) => {
        Swal.fire({
            icon: 'success',
            title: res.data.title,
            text: res.data.text
        })
        router.get(`/bimbingans/${props.id}`)
    })
    .catch((err) => {
        console.log(err)
    })
}

const setDateToIndo = (date) => {
    return moment(date).format('LLL');
}

const goToGoggleDrive = (link) => {
    return window.open(link, '_blank')
}
</script>
<template>
    <div class="bg-white rounded-md shadow overflow-x-auto mt-3">
        <table class="w-full whitespace-nowrap">
            <thead>
                <tr class="text-left font-bold">
                    <th class="pb-4 pt-6 px-6">Waktu Bimbingan</th>
                    <th class="pb-4 pt-6 px-6">Keterangan Bimbingan</th>
                    <th class="pb-4 pt-6 px-6">Catatan Pembimbing</th>
                    <th class="pb-4 pt-6 px-6">Tahapan Bimbingan</th>
                    <th class="pb-4 pt-6 px-6">ACC Bimbingan</th>
                    <th class="pb-4 pt-6 px-6">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="bimbingan in bimbingans" :key="bimbingan.id" class="hover:bg-gray-100">
                    <td class="border-t items-center px-6 py-4">
                        {{ setDateToIndo(bimbingan.created_at) }}
                    </td>
                    <td class="border-t items-center px-6 py-4">
                        {{ bimbingan.keterangan_bimbingan }}
                    </td>
                    <td v-if="bimbingan.catatan_pembimbing" class="border-t items-center px-6 py-4">
                        {{ bimbingan.catatan_pembimbing }}
                    </td>
                    <td v-else class="border-t items-center px-6 py-4">
                        <ModalCreateCatatanPembimbing v-if="user.role == 2" :id="bimbingan.id" :id_mahasiswa="id"/>
                    </td>
                    <td class="border-t items-center px-6 py-4">
                        {{ bimbingan.tahap_bimbingan }}
                    </td>
                    <td class="border-t items-center px-6 py-4">
                        <StatusConfirm :isConfirm="bimbingan.confirmed"/>
                    </td>
                    <td class="border-t items-center px-6 py-4">
                        <div class="flex flex-row space-x-4">
                            <DestroyButton v-if="user.role == 2" @click="destroy(bimbingan.id)"><i class="fa-solid fa-trash text-white"></i></DestroyButton>
                            <ModalUpdateBimbingan v-if="user.role == 4 || user.role == 2" :id="bimbingan.id" :id_mahasiswa="id"/>
                            <GoogleDriveButton v-if="user.role == 4 || user.role == 2" @click="goToGoggleDrive(bimbingan.link)"><i class="fa-brands fa-google-drive text-white fa-lg"></i></GoogleDriveButton>
                            <DetailButton v-if="user.role == 2" @click="confirmed(bimbingan.id)"><i class="fa-solid fa-square-check fa-lg"></i></DetailButton>
                        </div>
                    </td>
                </tr>
                <tr v-if="bimbingans.length === 0">
                    <td class="px-6 py-4 text-center border-t" colspan="5">No data found.</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>