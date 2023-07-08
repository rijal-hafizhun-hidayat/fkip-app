<script setup>
import { onMounted, ref, watch } from 'vue';
import axios from 'axios';
import NProgress from 'nprogress';
import DestroyButton from '@/Components/DestroyButton.vue';
import UpdateButton from '@/Components/UpdateButton.vue';
import DetailButton from '@/Components/DetailButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputSearch from '@/Components/InputSearch.vue';
import { router } from '@inertiajs/vue3'
import Swal from 'sweetalert2'
import { TailwindPagination } from 'laravel-vue-pagination';

const props = defineProps({
    user: Object
})

const guruPamongs = ref([])
const search = ref('')
const routeGetGuruPamong = ref('')
const length = ref('')

onMounted(() => {
    if(props.user.role === 2){
        getGuruPamongByIdDpl()
    }
    else{
        getGuruPamong()
    }
})

const show = (id) => {
    router.get(`/guru-pamong/${id}`)
}

const destroy = (id) => {
    NProgress.start()
    axios.delete(`/guru-pamong/${id}`)
    .then((res) => {
        Swal.fire({
            icon: 'success',
            title: res.data.title,
            text: res.data.text
        })
        router.get('/guru-pamong')
    })
    .catch((err) => {
        console.log(err)
    })
    .finally(() => {
        NProgress.done()
    })
}

const getGuruPamong = (page = 1, nama) => {
    routeGetGuruPamong.value = nama == null ? `/getGuruPamongs?page=${page}` : `/getGuruPamongs?page=${page}&nama=${nama}`

    NProgress.start()
    axios.get(routeGetGuruPamong.value)
    .then((res) => {
        guruPamongs.value = res.data.data
        length.value = res.data.data.data.length
    })
    .catch((err) => {
        console.log(err)
    })
    .finally(() => {
        NProgress.done()
    })
}

const getGuruPamongByIdDpl = (page = 1, nama) => {
    routeGetGuruPamong.value = nama == null ? `/getGuruPamongByIdDpl/${props.user.id_dpl}?page=${page}` : `/getGuruPamongByIdDpl/${props.user.id_dpl}?page=${page}&nama=${nama}`

    NProgress.start()
    axios.get(routeGetGuruPamong.value)
    .then((res) => {
        guruPamongs.value = res.data.data
        length.value = res.data.data.data.length
    })
    .catch((err) => {
        console.log(err)
    })
    .finally(()=> {
        NProgress.done()
    })
}

const addAsosiasiMahasiswa = (id) => {
    router.get(`/guru-pamong/mahasiswa/${id}`)
}

const reset = () => {
    router.visit('/guru-pamong', {
        method: 'get'
    })
}

watch(search, async (newSearch, oldSearch) => {
    if(newSearch != null){
        if(props.user.role == 1){
            getGuruPamong(1, newSearch)
        }
        else{
            getGuruPamongByIdDpl(1, newSearch)
        }
    }
})
</script>
<template>
    <InputSearch v-model="search" />
    <PrimaryButton @click="reset" class="ml-5 py-3">Reset</PrimaryButton>

    <div class="bg-white rounded-md shadow overflow-x-auto mt-10">
        <table class="w-full whitespace-nowrap">
            <thead>
                <tr class="text-left font-bold">
                    <th class="pb-4 pt-6 px-6">Nama</th>
                    <th class="pb-4 pt-6 px-6">Asal</th>
                    <th class="pb-4 pt-6 px-6">Sekolah</th>
                    <th class="pb-4 pt-6 px-6">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="guruPamong in guruPamongs.data" :key="guruPamong.id" class="hover:bg-gray-100">
                    <td class="border-t items-center px-6 py-4">
                        {{ guruPamong.nama }}
                    </td>
                    <td class="border-t items-center px-6 py-4">
                        {{ guruPamong.asal }}
                    </td>
                    <td class="border-t items-center px-6 py-4">
                        {{ guruPamong.asal_sekolah }}
                    </td>
                    <td class="border-t items-center px-6 py-4">
                        <div class="flex flex-row space-x-4">
                            <DestroyButton v-if="user.role === 1" @click="destroy(guruPamong.id)"><i class="fa-solid fa-trash text-white"></i></DestroyButton>
                            <UpdateButton v-if="user.role === 1" @click="show(guruPamong.id)"><i class="fa-solid fa-pen-to-square text-white"></i></UpdateButton>
                            <DetailButton v-if="user.role === 1 || user.role === 2" @click="addAsosiasiMahasiswa(guruPamong.id)"><i :class="user.role === 1 ? 'fa-solid fa-person-circle-plus fa-xl' : 'fa-solid fa-people-arrows fa-xl'"></i></DetailButton>
                        </div>
                    </td>
                </tr>
                <tr v-if="length === 0">
                    <td class="px-6 py-4 text-center border-t" colspan="4">No data found.</td>
                </tr>
            </tbody>
        </table>
    </div>
    <TailwindPagination v-if="user.role === 1" class="mt-6" :data="guruPamongs" @pagination-change-page="getGuruPamong" />
    <TailwindPagination v-if="user.role === 2" class="mt-6" :data="guruPamongs" @pagination-change-page="getGuruPamongByIdDpl" />
</template>