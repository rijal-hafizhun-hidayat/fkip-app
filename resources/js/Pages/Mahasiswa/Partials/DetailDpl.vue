<script setup>
import { onMounted, reactive, ref } from 'vue'
import axios from 'axios';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { router } from '@inertiajs/vue3'
import nprogress from 'nprogress';

const props = defineProps({
    id: Number
})
const dpls = ref([])

onMounted(() => {
    getDplByIdMahasiswa()
});

const getDplByIdMahasiswa = () => {
    nprogress.start()
    axios.get(`/getDplByIdMahasiswa/${props.id}`)
    .then((res) => {
        dpls.value = res.data
    })
    .catch((err) => {
        console.log(err)
    })
    .finally(() => {
        nprogress.done()
    })
}

const goToRouteDetailDpl = (id) => {
    router.get(`/dpl/asosiasi/${id}`)
}
</script>
<template>
    <div class="bg-white rounded-md shadow-md overflow-x-auto mt-10">
        <p class="pb-4 pt-6 px-6 border-b font-bold text-xl">DPL</p>
        <table class="w-full whitespace-nowrap">
            <thead>
                <tr class="text-left font-bold">
                    <th class="pb-4 pt-6 px-6">Nama</th>
                    <th class="pb-4 pt-6 px-6">Prodi</th>
                    <th class="pb-4 pt-6 px-6">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-if="dpls.data" class="hover:bg-gray-100">
                    <td class="border-t items-center px-6 py-4">
                        {{ dpls.data.nama }}
                    </td>
                    <td class="border-t items-center px-6 py-4">
                        {{ dpls.data.prodi }}
                    </td>
                    <td class="border-t items-center px-6 py-4">
                        <PrimaryButton @click="goToRouteDetailDpl(dpls.data.id)"><i class="fa-solid fa-circle-info"></i></PrimaryButton>
                    </td>
                </tr>
                <tr v-else>
                    <td class="px-6 py-4 text-center border-t" colspan="3">No data found</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>