<script setup>
import { onMounted, ref } from 'vue'
import axios from 'axios'
import Notification from '@/Components/Notification.vue';
import AddAsosiasi from './AddAsosiasi.vue';

const guruPamong = ref([])
const props = defineProps({
    id_mahasiswa: Number
})

onMounted(() => {
    getGuruPamongByIdMahasiswa()
})

const getGuruPamongByIdMahasiswa = () => {
    axios.get(`/getGuruPamongByIdMahasiswa/${props.id_mahasiswa}`)
    .then((res) => {
        guruPamong.value = res.data.data
    })
    .catch((err) => {
        console.log(err)
    })
}
</script>
<template>
    <Notification v-if="!guruPamong" :level="'guru-pamong'"/>
    <div class="bg-white mt-10 px-4 py-6 rounded shadow-md overflow-x-auto">
        <div class="flex justify-between ms-5 mb-5">
            <div><p class="font-semibold text-xl text-gray-800">Terhubung Guru Pamong</p></div>
            <div v-if="guruPamong"><AddAsosiasi :asosiasi="'guru-pamong'" :keterangan="'Ubah Guru Pamong'"/></div>
            <div v-else><AddAsosiasi :asosiasi="'guru-pamong'" :keterangan="'Hubungkan Guru Pamong'"/></div>
        </div>
        
        <hr>
        <table class="w-full whitespace-nowrap">
            <thead>
                <tr class="text-left font-bold">
                    <th class="pb-4 pt-6 px-6">Nama</th>
                    <th class="pb-4 pt-6 px-6">Sekolah</th>
                    <th class="pb-4 pt-6 px-6">Bidang Studi</th>
                </tr>
            </thead>
            <tbody>
                <tr v-if="guruPamong" class="hover:bg-gray-100">
                    <td class="border-t items-center px-6 py-4">
                        {{ guruPamong.nama }}
                    </td>
                    <td class="border-t items-center px-6 py-4">
                        {{ guruPamong.asal_sekolah }}
                    </td>
                    <td class="border-t items-center px-6 py-4">
                        {{ guruPamong.bidang_keahlian }}
                    </td>
                </tr>
                <tr v-else>
                    <td class="py-4 text-center border-t" colspan="4">No data found.</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>