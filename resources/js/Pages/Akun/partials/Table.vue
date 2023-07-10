<script setup>
import { onMounted, ref, watch } from 'vue';
import axios from 'axios';
import NProgress from 'nprogress';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DestroyButton from '@/Components/DestroyButton.vue';
import UpdateButton from '@/Components/UpdateButton.vue';
import ResetButton from '@/Components/ResetButton.vue';
import { router } from '@inertiajs/vue3'
import Swal from 'sweetalert2'
import Pagination from '@/Components/Pagination.vue';
import { TailwindPagination } from 'laravel-vue-pagination';
import InputSearch from '@/Components/InputSearch.vue';

const akuns = ref([])
const search = ref('')
const routeGetAkuns = ref('')
const length = ref('')
        
onMounted(() => {
    getAkuns()
})

const getAkuns = (page = 1, nama) => {
    routeGetAkuns.value = nama == null ? `/getAkuns?page=${page}` : `/getAkuns?page=${page}&nama=${nama}`

    NProgress.start()
    axios.get(routeGetAkuns.value)
    .then((res) => {
        akuns.value = res.data.data
        length.value = res.data.data.data.length
    })
    .catch((err) => {
        console.log(err)
    })
    .finally(() => {
        NProgress.done()
    })
}

const destroy = (id) => {
    NProgress.start()
    axios.delete(`/akun/${id}`)
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
    .finally(() => {
        NProgress.done()
    })
}

const update = (id) => {
    router.get(`/akun/${id}`)
}

const reset = () => {
    router.visit('/akun', {
        method: 'get'
    })
}

const formResetPass = (id) => {
    router.get(`/akun/reset-pass/${id}`)
    //console.log(id)
}

watch(search, async (newSearch, oldSearch) => {
    if(newSearch != null){
        getAkuns(1, newSearch)
    }
})
</script>

<template>
    <InputSearch v-model="search" />
    <PrimaryButton @click="reset" class="ml-5 py-3">Reset</PrimaryButton>
    
    <div class="bg-white rounded-md shadow overflow-x-auto mt-5">
        <table class="w-full whitespace-nowrap">
            <thead>
                <tr class="text-left font-bold">
                    <th class="pb-4 pt-6 px-6">Nama</th>
                    <th class="pb-4 pt-6 px-6">Username</th>
                    <th class="pb-4 pt-6 px-6">Email</th>
                    <th class="pb-4 pt-6 px-6">Hak Akses</th>
                    <th class="pb-4 pt-6 px-6">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="akun in akuns.data" :key="akun.id" class="hover:bg-gray-100">
                    <td class="border-t items-center px-6 py-4">
                        {{ akun.nama }}
                    </td>
                    <td class="border-t items-center px-6 py-4">
                        {{ akun.username }}
                    </td>
                    <td class="border-t items-center px-6 py-4">
                        {{ akun.email }}
                    </td>
                    <td v-if="akun.role == 1" class="border-t items-center px-6 py-4">
                        Admin
                    </td>
                    <td v-else-if="akun.role == 2" class="border-t items-center px-6 py-4">
                        DPL
                    </td>
                    <td v-else class="border-t items-center px-6 py-4">
                        Guru Pamong
                    </td>
                    <td class="border-t items-center px-6 py-4">
                    <div class="flex flex-row space-x-4">
                        <DestroyButton @click="destroy(akun.id)"><i class="fa-solid fa-trash text-white"></i></DestroyButton>
                        <UpdateButton @click="update(akun.id)"><i class="fa-solid fa-pen-to-square text-white"></i></UpdateButton>
                        <ResetButton @click="formResetPass(akun.id)"><i class="fa-solid fa-unlock text-white fa-lg"></i></ResetButton>
                    </div>
                    
                    </td>
                </tr>
                <tr v-if="length === 0">
                    <td class="px-6 py-4 text-center border-t" colspan="5">No organizations found.</td>
                </tr>
            </tbody>
        </table>
    </div>
    <TailwindPagination class="mt-6" :data="akuns" @pagination-change-page="getAkuns" />
</template>