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

const props = defineProps({
    user: Object,
    prodis: Object
})
const mahasiswas = ref([])
const length = ref('')
const filter = reactive({
    nama: '',
    jenis_plp: '',
    prodi: '',
    is_nilai: '',
    orderByNim: '',
    orderByNama: '',
    orderByNilai: ''
})

onMounted(() => {
    if(props.user.role == 3){
        getMahasiswaByIdGuruPamong(props.user.id_guru_pamong)
    }
    else if(props.user.role == 2){
        getMahasiswaBimbinganByIdDpl(props.user.id_dpl)
    }
    else{
        getMahasiswa()
    } 
})

const getMahasiswa = (page = 1, newFilter = filter) => {
    NProgress.start()
    axios.get(`/getMahasiswa?page=${page}`, {
        params: {
            nama: newFilter.nama,
            jenis_plp: newFilter.jenis_plp,
            prodi: newFilter.prodi,
            is_nilai: newFilter.is_nilai,
            order_by_nim: newFilter.orderByNim,
            order_by_nama: newFilter.orderByNama,
            order_by_nilai: newFilter.orderByNilai
        }
    })
    .then((res) => {
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
            jenis_plp: newFilter.jenis_plp,
            prodi: newFilter.prodi,
            is_nilai: newFilter.is_nilai
        }
    })
    .then((res) => {
        mahasiswas.value = res.data
        length.value = res.data.data.length
    })
    .catch((err) => {
        console.log(err)
    })
    .finally(() => {
        NProgress.done()
    })
}

const getMahasiswaBimbinganByIdDpl = (newFilter = filter) => {
    NProgress.start()
    axios.get(`/getMahasiswaBimbinganByIdDpl/${props.user.id_dpl}`, {
        params: {
            nama: newFilter.nama,
            jenis_plp: newFilter.jenis_plp,
            prodi: newFilter.prodi,
            is_nilai: newFilter.is_nilai
        }
    })
    .then((res) => {
        mahasiswas.value = res.data
        length.value = res.data.data.length
    })
    .catch((err) => {
        console.log(err)
    })
    .finally(() => {
        NProgress.done()
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
    switch(jenisPlp){
        case 'plp_1':
            return 'PLP 1';
            break;
        case 'plp_2':
            return 'PLP 2';
            break;
        case 'km_plp_1':
            return 'Kampus Mengajar (PLP 1)';
            break;
        case 'km_plp_2':
            return 'Kampus Mengajar (PLP 2)';
            break;
        case 'am_plp_2':
            return 'Asistensi Mengajar';
            break;
        default:
            return 'udentified';
            break;
    }
}

const goToRouteBimbingan = (id) => {
    router.get(`/bimbingans/${id}`)
}

const asosiasiMahasiswa = (id) => {
    router.get(`/mahasiswa/asosiasi/${id}`)
}

watch(filter, async (newFilter, oldSearch) => {
    if(props.user.role == 1){
        getMahasiswa()
    }
    else if(props.user.role == 2){
        getMahasiswaBimbinganByIdDpl()
    }
    else{
        getMahasiswaByIdGuruPamong()
    }
})
</script>
<template>
    <div class="mb-4 grid grid-cols-1 gap-4 sm:grid-cols-4">
        <InputSearch v-if="user.role == 1" v-model="filter.nama" placeholder="Cari Nama"/>
        <SelectInput v-model="filter.jenis_plp">
            <option disabled value=""> -- Pilih PLP --</option>
            <option value="plp_1">PLP 1</option>
            <option value="plp_2">PLP 2 </option>
            <option value="km_plp_1">Kampus Merdeka (PLP 1)</option>
            <option value="km_plp_2">Kampus Merdeka (PLP 2)</option>
            <option value="am_plp_2">Asistensi Mengajar</option>
        </SelectInput>
        <SelectInput v-if="user.role == 1" v-model="filter.prodi">
            <option disabled value=""> -- Pilih Prodi --</option>
            <option v-for="prodi in prodis">{{ prodi.nama }}</option>
        </SelectInput>
        <SelectInput v-model="filter.is_nilai">
            <option disabled value=""> -- Pilih Nilai --</option>
            <option value="ada">Ada Nilai</option>
            <option value="tidak">Tidak Ada Nilai</option>
        </SelectInput>
        <SelectInput v-if="user.role == 1" v-model="filter.orderByNama">
            <option disabled value=""> -- Urut Berdasarkan Nama --</option>
            <option value="asc">Ascending</option>
            <option value="desc">Descending</option>
        </SelectInput>
    </div>
    <PrimaryButton @click="reset">Reset</PrimaryButton>

    <div class="bg-white rounded-md shadow overflow-x-auto mt-10">
        <table class="w-full whitespace-nowrap">
            <thead>
                <tr class="text-left font-bold">
                    <th class="pb-4 pt-6 px-6">Nim</th>
                    <th class="pb-4 pt-6 px-6">Nama</th>
                    <th class="pb-4 pt-6 px-6">Jenis PLP</th>
                    <th class="pb-4 pt-6 px-6">Prodi</th>
                    <th class="pb-4 pt-6 px-6">Nilai Total</th>
                    <th v-if="user.role == 1" class="pb-4 pt-6 px-6">Action</th>
                    <th v-if="user.role == 2 || user.role == 1" class="pb-4 pt-6 px-6">Rincian Nilai</th>
                    <th v-if="user.role == 2 || user.role == 1" class="pb-4 pt-6 px-6">Form Bimbingan</th>
                    <th v-if="user.role == 3" class="pb-4 pt-6 px-6">Input Nilai</th>
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
                        {{ mahasiswa.nilai }}
                    </td>
                    <td v-if="user.role == 1" class="border-t items-center px-6 py-4">
                        <div class="flex flex-row space-x-4">
                            <DestroyButton v-if="user.role == 1" @click="destroy(mahasiswa.id)"><i class="fa-solid fa-trash text-white"></i></DestroyButton>
                            <UpdateButton v-if="user.role == 1" @click="show(mahasiswa.id)"><i class="fa-solid fa-pen-to-square text-white"></i></UpdateButton>
                            <PrimaryButton v-if="user.role == 1" @click="asosiasiMahasiswa(mahasiswa.id)"><i class="fa-solid fa-circle-info"></i></PrimaryButton>
                        </div>
                    </td>
                    <td v-if="user.role == 2 || user.role == 1 || user.role == 3" class="border-t items-center px-6 py-4">
                        <div class="flex flex-row space-x-4">
                            <DetailButton @click="addNilai(mahasiswa.jenis_plp, mahasiswa.prodi, mahasiswa.id)"><i class="fa-solid fa-file-pen fa-lg"></i></DetailButton>
                        </div>
                    </td>
                    <td v-if="user.role == 2 || user.role == 1" class="border-t items-center px-6 py-4">
                        <div class="flex flex-row space-x-4">
                            <PrimaryButton v-if="user.role == 2 || user.role == 5 || user.role == 1" @click="goToRouteBimbingan(mahasiswa.id)"><i class="fa-solid fa-person-chalkboard fa-lg"></i></PrimaryButton>
                        </div>
                    </td>
                </tr>
                <tr v-if="length == 0">
                    <td class="px-6 py-4 text-center border-t" colspan="8">No data found</td>
                </tr>
            </tbody>
        </table>
    </div>
    <TailwindPagination v-if="user.role == 1" class="mt-6" :keepLength="true" :limit="1" :data="mahasiswas" @pagination-change-page="getMahasiswa" />
</template>