<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import axios from 'axios';
import { onMounted, ref } from 'vue'
import DestroyButton from '@/Components/DestroyButton.vue';
import UpdateButton from '@/Components/UpdateButton.vue';
import moment from 'moment';

const bimbingans = ref([])
const props = defineProps({
    id: Number
})

onMounted(() => {
    getBimbinganByIdMahasiswa()
})

const getBimbinganByIdMahasiswa = () => {
    axios.get(`/getBimbinganByIdMahasiswa/${props.id}`)
    .then((res) => {
        bimbingans.value = res.data.data
        console.log(bimbingans.value)
    })
    .catch((err) => {
        console.log(err)
    })
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
                    <th class="pb-4 pt-6 px-6">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="bimbingan in bimbingans" :key="bimbingan.id" class="hover:bg-gray-100">
                    <td class="border-t items-center px-6 py-4">
                        {{ bimbingan.created_at }}
                    </td>
                    <td class="border-t items-center px-6 py-4">
                        {{ bimbingan.keterangan_bimbingan }}
                    </td>
                    <td class="border-t items-center px-6 py-4">
                        {{ bimbingan.catatan_pembimbing }}
                    </td>
                    <td class="border-t items-center px-6 py-4">
                        <div class="flex flex-row space-x-4">
                            <DestroyButton><i class="fa-solid fa-trash text-white"></i></DestroyButton>
                            <UpdateButton><i class="fa-solid fa-pen-to-square text-white"></i></UpdateButton>
                        </div>
                    </td>
                </tr>
                <tr v-if="length === 0">
                    <td class="px-6 py-4 text-center border-t" colspan="5">No data found.</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>