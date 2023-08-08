<script setup>
import { onMounted, ref, watch, reactive } from 'vue';
import axios from 'axios';
import NProgress from 'nprogress';
import DestroyButton from '@/Components/DestroyButton.vue';
import UpdateButton from '@/Components/UpdateButton.vue';
import DetailButton from '@/Components/DetailButton.vue';
import { router } from '@inertiajs/vue3'
import Swal from 'sweetalert2'
import { TailwindPagination } from 'laravel-vue-pagination';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputSearch from '@/Components/InputSearch.vue';
import SelectInput from '@/Components/SelectInput.vue';
import AsosiasiButton from '@/Components/AsosiasiButton.vue';

const props = defineProps({
    user: Object
})

const mahasiswas = ref([])
const length = ref('')
const filter = reactive({
    nama: '',
    jenis_plp: ''
})

onMounted(() => {
    if(props.user.role == 3){
        getMahasiswaByIdGuruPamong(props.user.id_guru_pamong)
    }
    else if(props.user.role == 2){
        getMahasiswaByIdDpl(props.user.id_dpl)
    }
    else{
        getMahasiswa(filter)
    } 
})

const getMahasiswa = (page = 1, newFilter = filter) => {
    NProgress.start()
    axios.get(`/getMahasiswa?page=${page}`, {
        params: {
            nama: newFilter.nama,
            jenis_plp: newFilter.jenis_plp
        }
    })
    .then((res) => {
        console.log(res)
        mahasiswas.value = res.data.data
        length.value = res.data.data.data.length
    })
    .catch((err) => {
        console.log(err)
    })
    .finally(() => {
        NProgress.done()
    })
}

const getMahasiswaByIdGuruPamong = (newFilter = filter) => {
    NProgress.start()
    axios.get(`/getMahasiswaByIdAkun/${props.user.id_guru_pamong}`, {
        params: {
            nama: newFilter.nama,
            jenis_plp: newFilter.jenis_plp
        }
    })
    .then((res) => {
        mahasiswas.value = res.data.data
        console.log(res.data.data.length)
    })
    .catch((err) => {
        console.log(err)
    })
    .finally(() => {
        NProgress.done()
    })
}

const getMahasiswaByIdDpl = (id) => {
    axios.get(`/getMahasiswaByIdDpl/${props.user.id_dpl}`)
    .then((res) => {
        mahasiswas.value = res.data
    })
    .catch((err) => {
        console.log(err)
    })
}

const show = (id) => {
    router.get(`/mahasiswa/${id}`)
}

const destroy = (id) => {
    NProgress.start()
    axios.delete(`/mahasiswa/${id}`)
    .then((res) => {
        Swal.fire({
            icon: 'success',
            title: res.data.title,
            text: res.data.text
        })
        router.get('/mahasiswa')
    })
    .catch((err) => {
        console.log(err)
    })
    .finally(() => {
        NProgress.done()
    })
}

const addNilai = (jenisPlp, jenisBidang, id) => {
    jenisBidang = setJenisBidang(jenisBidang)
    router.get(`/mahasiswa/nilai/${jenisPlp}/${jenisBidang}/${id}`)
}

const setJenisBidang = (prodi) => {
    if(prodi == 'Bimbingan dan Konseling'){
        prodi = 'bk'
    }
    else if(prodi == 'Pendidikan Guru Pendidikan Anak Usia Dini'){
        prodi = 'pgpaud'
    }
    else{
        prodi = 'teaching'
    }
    return prodi
}

const reset = () => {
    router.visit('/mahasiswa', {
        method: 'get'
    })
}

const setJenisPlp = (jenisPlp) => {
    let setPlp = ''
    if(jenisPlp == 'plp_2'){
        setPlp = 'PLP 2'
    }
    else{
        setPlp = 'PLP 1'
    }
    return setPlp
}

const goToRouteBimbingan = (id) => {
    router.get(`/bimbingans/${id}`)
}

watch(filter, async (newFilter, oldSearch) => {
    if(props.user.role == 1){
        getMahasiswa()
    }
    else if(props.user.role == 2){

    }
    else{
        getMahasiswaByIdGuruPamong()
    }
})
</script>
<template>
    <div class="space-x-4">
        <InputSearch v-model="filter.nama" />
        <SelectInput v-model="filter.jenis_plp">
            <option disabled value=""> -- Pilih --</option>
            <option value="plp_1">PLP 1</option>
            <option value="plp_2">PLP 2</option>
        </SelectInput>
        <PrimaryButton @click="reset" class="ml-5 py-3">Reset</PrimaryButton>
    </div>

    <div class="bg-white rounded-md shadow overflow-x-auto mt-10">
        <table class="w-full whitespace-nowrap">
            <thead>
                <tr class="text-left font-bold">
                    <th class="pb-4 pt-6 px-6">Nim</th>
                    <th class="pb-4 pt-6 px-6">Nama</th>
                    <th class="pb-4 pt-6 px-6">Jenis PLP</th>
                    <th class="pb-4 pt-6 px-6">Prodi</th>
                    <th class="pb-4 pt-6 px-6">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="mahasiswa in mahasiswas.data" :key="mahasiswa.id" class="hover:bg-gray-100">
                    <td class="border-t items-center px-6 py-4">
                        {{ mahasiswa.nim }}
                    </td>
                    <td class="border-t items-center px-6 py-4">
                        {{ mahasiswa.nama }}
                    </td>
                    <td class="border-t items-center px-6 py-4">
                        {{ setJenisPlp(mahasiswa.jenis_plp) }}
                    </td>
                    <td class="border-t items-center px-6 py-4">
                        {{ mahasiswa.prodi }}
                    </td>
                    <td class="border-t items-center px-6 py-4">
                        <div class="flex flex-row space-x-4">
                            <DestroyButton v-if="user.role == 1" @click="destroy(mahasiswa.id)"><i class="fa-solid fa-trash text-white"></i></DestroyButton>
                            <UpdateButton v-if="user.role == 1" @click="show(mahasiswa.id)"><i class="fa-solid fa-pen-to-square text-white"></i></UpdateButton>
                            <DetailButton @click="addNilai(mahasiswa.jenis_plp, mahasiswa.prodi, mahasiswa.id)"><i class="fa-solid fa-file-pen fa-lg"></i></DetailButton>
                            <PrimaryButton v-if="user.role == 2 || user.role == 5" @click="goToRouteBimbingan(mahasiswa.id)"><i class="fa-solid fa-person-chalkboard fa-lg"></i></PrimaryButton>
                        </div>
                    </td>
                </tr>
                <tr v-if="length === 0">
                    <td class="px-6 py-4 text-center border-t" colspan="5">No data found.</td>
                </tr>
            </tbody>
        </table>
    </div>
    <TailwindPagination v-if="user.role === 1" class="mt-6" :keepLength="true" :limit="1" :data="mahasiswas" @pagination-change-page="getMahasiswa" />
</template>