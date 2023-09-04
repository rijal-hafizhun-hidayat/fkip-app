<script setup>
import { onMounted, ref } from 'vue'
import axios from 'axios';
import nprogress from 'nprogress';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { router } from '@inertiajs/vue3'

const guruPamong = ref([])
const props = defineProps({
    id: Number
})

onMounted(() => {
    getGuruPamongByIdMahasiswa()
})

const getGuruPamongByIdMahasiswa = () => {
    nprogress.start()
    axios.get(`/getGuruPamongByIdMahasiswa/${props.id}`)
    .then((res) => {
        guruPamong.value = res.data
    })
    .catch((err) => {
        console.log(err)
    })
    .finally(() => {
        nprogress.done()
    })
}

const goToRouteDetailGuruPamong = (id) => {
    router.get(`/guru-pamong/mahasiswa/${id}`)
}
</script>
<template>
    <div class="bg-white rounded-md shadow-md overflow-x-auto mt-10">
        <p class="pb-4 pt-6 px-6 border-b font-bold text-xl">Guru Pamong</p>
        <table class="w-full whitespace-nowrap">
            <thead>
                <tr class="text-left font-bold">
                    <th class="pb-4 pt-6 px-6">Nama</th>
                    <th class="pb-4 pt-6 px-6">Bidang Keahlian</th>
                    <th class="pb-4 pt-6 px-6">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-if="guruPamong.data" class="hover:bg-gray-100">
                    <td class="border-t items-center px-6 py-4">
                        {{ guruPamong.data.nama }}
                    </td>
                    <td class="border-t items-center px-6 py-4">
                        {{ guruPamong.data.bidang_keahlian }}
                    </td>
                    <td class="border-t items-center px-6 py-4">
                        <PrimaryButton @click="goToRouteDetailGuruPamong(guruPamong.data.id)"><i class="fa-solid fa-circle-info"></i></PrimaryButton>
                    </td>
                </tr>
                <tr v-else>
                    <td class="px-6 py-4 text-center border-t" colspan="3">No data found</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>