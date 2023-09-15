<script setup>
import DestroyButton from '@/Components/DestroyButton.vue';
import UpdateButton from '@/Components/UpdateButton.vue';
import SelectInput from '@/Components/SelectInput.vue';
import { router } from '@inertiajs/vue3';
import axios from 'axios';
import { onMounted, ref, watch, reactive } from 'vue'
import nprogress from 'nprogress';
import Swal from 'sweetalert2';
import InputSearch from '@/Components/InputSearch.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { TailwindPagination } from 'laravel-vue-pagination';

const sekolahs = ref([])
const total = ref('')
const filter = reactive({
    nama: '',
    jenis_plp: ''
})

onMounted(() => {
    getSekolah()
})

const getSekolah = (page = 1, newFilter = filter) => {
    axios.get(`/getSekolah?page=${page}`, {
        params: {
            nama: newFilter.nama,
            jenis_plp: newFilter.jenis_plp
        }
    })
    .then((res) => {
        sekolahs.value = res.data.data
        total.value = res.data.data.total
    })
    .catch((err) => {
        console.log(err)
    })
}

const destroy = (id) => {
    nprogress.start()
    axios.delete(`/sekolah/${id}`)
    .then((res) => {
        Swal.fire({
            icon: 'success',
            title: res.data.title,
            text: res.data.text
        })
        router.get('/sekolah')
    })
    .catch((err) => {
        console.log(err)
    })
    .finally(() => {
        nprogress.done()
    })
}

const reset = () => {
    router.get('/sekolah')
}

const show = (id) => {
    router.get(`/sekolah/${id}`)
}

const setJenisPlp = (jenisPlp) => {
    if(jenisPlp == 'plp_1'){
        jenisPlp = 'PLP 1'
    }
    else if(jenisPlp == 'plp_2'){
        jenisPlp = 'PLP 2'
    }
    else if(jenisPlp == 'km_plp_1'){
        jenisPlp = 'Kampus Merdeka (PLP 1)'
    }
    else if(jenisPlp == 'km_plp_2'){
        jenisPlp = 'Kampus Merdeka (PLP 2)'
    }
    return jenisPlp
}

watch(filter, async (newFilter, oldFilter) => {
    getSekolah()
})
</script>
<template>
    <div class="flex space-x-4">
        <InputSearch v-model="filter.nama" placeholder="Cari Nama"/>
        <SelectInput v-model="filter.jenis_plp">
            <option selected disabled value="">-- Pilih --</option>
            <option value="plp_1">PLP 1</option>
            <option value="plp_2">PLP 2</option>
        </SelectInput>
        <PrimaryButton @click="reset">Reset</PrimaryButton>
    </div>
    
    <div class="bg-white rounded-md shadow overflow-x-auto mt-10">
        <table class="w-full whitespace-nowrap">
            <thead>
                <tr class="text-left font-bold">
                    <th class="pb-4 pt-6 px-6">Nama Sekolah</th>
                    <th class="pb-4 pt-6 px-6">PLP</th>
                    <th class="pb-4 pt-6 px-6">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="sekolah in sekolahs.data" :key="sekolah.id" class="hover:bg-gray-100">
                    <td class="border-t items-center px-6 py-4">
                        {{ sekolah.nama }}
                    </td>
                    <td class="border-t items-center px-6 py-4">
                        {{ setJenisPlp(sekolah.jenis_plp) }}
                    </td>
                    <td class="border-t items-center px-6 py-4">
                        <div class="flex flex-row space-x-4">
                            <DestroyButton @click="destroy(sekolah.id)"><i class="fa-solid fa-trash text-white"></i></DestroyButton>
                            <UpdateButton @click="show(sekolah.id)"><i class="fa-solid fa-pen-to-square text-white"></i></UpdateButton>
                        </div>
                    </td>
                </tr>
                <tr v-if="total == 0">
                    <td class="px-6 py-4 text-center border-t" colspan="3">No data found.</td>
                </tr>
            </tbody>
        </table>
    </div>
    <TailwindPagination class="mt-6" :keepLength="true" :limit="1" :data="sekolahs" @pagination-change-page="getSekolah" />
</template>