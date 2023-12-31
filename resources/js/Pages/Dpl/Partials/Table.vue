<script setup>
import { onMounted, ref, watch, reactive } from 'vue';
import axios from 'axios';
import NProgress from 'nprogress';
import DestroyButton from '@/Components/DestroyButton.vue';
import UpdateButton from '@/Components/UpdateButton.vue';
import DetailButton from '@/Components/DetailButton.vue';
import { router } from '@inertiajs/vue3'
import Swal from 'sweetalert2'
import InputSearch from '@/Components/InputSearch.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SelectInput from '@/Components/SelectInput.vue';
import { TailwindPagination } from 'laravel-vue-pagination';

const dpls = ref([])
const search = reactive({
    nama: '',
    prodi: '',
})
const length = ref('')

const props = defineProps({
    user: Object,
    prodis: Object
})

onMounted(() => {
    getDpl()      
})

const destroy = (id) => {
    NProgress.start()
    axios.delete(`/dpl/${id}`)
    .then((res) => {
        Swal.fire({
            icon: 'success',
            title: res.data.title,
            text: res.data.text
        })
        router.get('/dpl')
    })
    .catch((err) => {
        console.log(err)
    })
    .finally(() => {
        NProgress.done()
    })
}

const getDpl = (page = 1, filter = search) => {
    NProgress.start()
    axios.get(`/getDpls?page=${page}`, {
        params: {
            nama: filter.nama,
            prodi: filter.prodi,
            jenis_plp: filter.jenis_plp
        }
    })
    .then((res) => {
        dpls.value = res.data.data
        length.value = res.data.data.data.length
    })
    .catch((err) => {
        console.log(err)
    })
    .finally(() => {
        NProgress.done()
    })
}

const update = (id) => {
    router.get(`/dpl/${id}`)
}

const addBimbinganGuruPamong = (id) => {
    router.get(`/dpl/asosiasi/${id}`)
}

const reset = () => {
    router.visit('/dpl', {
        method: 'get'
    })
}

watch(search, async (newSearch, oldSearch) => {
    if(newSearch != null){
        getDpl()
    }
})
</script>

<template>
    <div class="min-[640px]:space-x-4 max-[640px]:grid grid-cols-1 gap-4">
        <InputSearch v-model="search.nama" placeholder="Cari Nama" />
        <SelectInput v-model="search.prodi">
            <option selected disabled value="">-- Pilih Prodi --</option>
            <option v-for="prodi in prodis">{{ prodi.nama }}</option>
        </SelectInput>
        <PrimaryButton @click="reset" class="py-3">Reset</PrimaryButton>
    </div>
    

    <div class="bg-white rounded-md shadow overflow-x-auto mt-10">
        <table class="w-full whitespace-nowrap">
            <thead>
                <tr class="text-left font-bold">
                    <th class="pb-4 pt-6 px-6">Nip / Niy</th>
                    <th class="pb-4 pt-6 px-6">Nama</th>
                    <th class="pb-4 pt-6 px-6">Prodi</th>
                    <th class="pb-4 pt-6 px-6">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="dpl in dpls.data" :key="dpl.id" class="hover:bg-gray-100">
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
                        <div class="flex flex-row space-x-4">
                            <DestroyButton @click="destroy(dpl.id)"><i class="fa-solid fa-trash text-white"></i></DestroyButton>
                            <UpdateButton @click="update(dpl.id)"><i class="fa-solid fa-pen-to-square text-white"></i></UpdateButton>
                            <DetailButton @click="addBimbinganGuruPamong(dpl.id)"><i class="fa-solid fa-person-circle-plus fa-xl"></i></DetailButton>
                        </div>
                    </td>
                </tr>
                <tr v-if="length == 0">
                    <td class="px-6 py-4 text-center border-t" colspan="5">No data found.</td>
                </tr>
            </tbody>
        </table>
    </div>
    <TailwindPagination :keepLength="true" :limit="1" class="mt-6" :data="dpls" @pagination-change-page="getDpl" />
</template>