<script setup>
import { onMounted, ref } from 'vue';
import axios from 'axios';
import DestroyButton from '@/Components/DestroyButton.vue';
import { router } from '@inertiajs/vue3'
import Swal from 'sweetalert2'

const guruPamong = ref([])
const props = defineProps({
    id: Number
})

console.log(props.id)

onMounted(() => {
    axios.get(`/getGuruPamongByIdGuruPamong/${props.id}`)
    .then((res) => {
        guruPamong.value = res.data.data
    })
    .catch((err) => {
        console.log(err)
    })
})

const destroyAsosiasiGuruPamong = () => {
    axios.put(`/destroyAsosiasiGuruPamong/${props.id}`)
    .then((res) => {
        Swal.fire({
            icon: 'success',
            title: res.data.title,
            text: res.data.text
        })
        router.get('/akun')
    })
    .catch((err) => {
        console.log(err)
    })
}
</script>
<template>
    <div class="bg-white rounded-md shadow-md overflow-x-auto mt-10">
        <p class="pb-4 pt-6 px-6 border-b font-bold text-xl">Akun Terhubung dengan Data Guru Pamong</p>
        <table class="w-full whitespace-nowrap">
            <thead>
                <tr class="text-left font-bold">
                    <th class="pb-4 pt-6 px-6">Nama</th>
                    <th class="pb-4 pt-6 px-6">Bidang Keahlian</th>
                    <th class="pb-4 pt-6 px-6">Asal Sekolah</th>
                    <th class="pb-4 pt-6 px-6">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-if="guruPamong" class="hover:bg-gray-100">
                    <td class="border-t items-center px-6 py-4">
                        {{ guruPamong.nama }}
                    </td>
                    <td class="border-t items-center px-6 py-4">
                        {{ guruPamong.bidang_keahlian }}
                    </td>
                    <td class="border-t items-center px-6 py-4">
                        {{ guruPamong.asal_sekolah }}
                    </td>
                    <td class="border-t items-center px-6 py-4">
                        <div class="flex flex-row space-x-4">
                            <DestroyButton @click="destroyAsosiasiGuruPamong"><i class="fa-solid fa-trash text-white"></i></DestroyButton>
                        </div>
                    </td>
                </tr>
                <tr v-else>
                    <td class="px-6 py-4 text-center border-t" colspan="4">No data found.</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>