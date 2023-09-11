<script setup>
import { onMounted, ref } from 'vue'
import axios from 'axios'
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Notification from '@/Components/Notification.vue';

const dpl = ref([])
const props = defineProps({
    id_mahasiswa: Number
})

onMounted(() => {
    getDplByIdMahasiswa()
})

const getDplByIdMahasiswa = () => {
    axios.get(`/getDplByIdMahasiswa/${props.id_mahasiswa}`)
    .then((res) => {
        dpl.value = res.data.data
    })
    .catch((err) => {
        console.log(err)
    })
}
</script>
<template>
    <Notification v-if="!dpl" :level="'dpl'"/>
    <div class="bg-white mt-10 px-4 py-6 rounded shadow-md">
        <div class="flex justify-between ms-5 mb-5">
            <div><p class="font-semibold text-xl text-gray-800">Terhubung DPL</p></div>
            <div v-if="dpl"><PrimaryButton>Ubah DPL</PrimaryButton></div>
            <div v-else><PrimaryButton>Hubungkan DPL</PrimaryButton></div>
        </div>
        <hr>
        <table class="w-full whitespace-nowrap">
            <thead>
                <tr class="text-left font-bold">
                    <th class="pb-4 pt-6 px-6">Nip / Niy</th>
                    <th class="pb-4 pt-6 px-6">Nama</th>
                    <th class="pb-4 pt-6 px-6">Prodi</th>
                    <th class="pb-4 pt-6 px-6">Email</th>
                    <th class="pb-4 pt-6 px-6">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-if="dpl" class="hover:bg-gray-100">
                    <td class="border-t items-center px-6 py-4">
                        {{ dpl.nipy }}
                    </td>
                    <td class="border-t items-center px-6 py-4">
                        {{ dpl.nama }}
                    </td>
                    <td class="border-t items-center px-6 py-4">
                        {{ dpl.prodi }}
                    </td>
                    <td class="border-t items-center px-6 py-4">
                        {{ dpl.email }}
                    </td>
                    <td class="border-t items-center px-6 py-4">
                        <div class="flex flex-row space-x-4">
                            <DestroyButton @click="destroyAsosiasiDpl"><i class="fa-solid fa-trash text-white"></i></DestroyButton>
                        </div>
                    </td>
                </tr>
                <tr v-else>
                    <td class="py-4 text-center border-t" colspan="5">No data found.</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>