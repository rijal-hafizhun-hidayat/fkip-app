<script setup>
import { onMounted, ref, computed } from 'vue';
import axios from 'axios';
import DestroyButton from '@/Components/DestroyButton.vue';
import DetailButton from '@/Components/DetailButton.vue';
import { router, usePage } from '@inertiajs/vue3'
import Swal from 'sweetalert2'
import nprogress from 'nprogress';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps({
    id: Number
})

const page = usePage()
const user = computed(() => page.props.auth.user)

const mahasiswas = ref([])

onMounted(() => {
    nprogress.start()
    axios.get(`/getMahasiswaByIdGuruPamong/${props.id}`)
    .then((res) => {
        console.log(res)
        mahasiswas.value = res.data.data
    })
    .catch((err) => {
        console.log(err)
    })
    .finally(() => {
        nprogress.done()
    })
})

const destroyAsosiasiMahasiswa = (id) => {
    axios.put(`/destroyAsosiasiMahasiswa/${id}`)
    .then((res) => {
        Swal.fire({
            icon: 'success',
            title: res.data.title,
            text: res.data.text
        })
        router.get(`/guru-pamong/mahasiswa/${props.id}`)
    })
    .catch((err) => {
        console.log(err)
    })
}

const setJenisPlp = (jenis_plp) => {
    let setPlp = ''
    if(jenis_plp == 'plp_1'){
        setPlp = 'PLP 1'
    }
    else if(jenis_plp == 'plp_2'){
        setPlp = 'PLP 2' 
    }
    else if(jenis_plp == 'km_plp_1'){
        setPlp = 'Kampus Mengajar (PLP 1)'
    }
    else if(jenis_plp == 'km_plp_2'){
        setPlp = 'Kampus Mengajar (PLP 2)'
    }
    else if(jenis_plp == 'am_plp_2'){
        setPlp = 'Asistensi Mengajar 2'
    }
    return setPlp
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

const nilaiMahasiswa = (jenisPlp, prodi, id) => {
    prodi = setJenisBidang(prodi)
    //console.log(jenisPlp, prodi, id)
    router.get(`/mahasiswa/nilai/${jenisPlp}/${prodi}/${id}`)
}
</script>
<template>
    <div class="bg-white rounded-md shadow-md overflow-x-auto mt-10">
        <table class="w-full whitespace-nowrap">
            <thead>
                <tr class="text-left font-bold">
                    <th class="pb-4 pt-6 px-6">Nim</th>
                    <th class="pb-4 pt-6 px-6">Nama</th>
                    <th class="pb-4 pt-6 px-6">Prodi</th>
                    <th class="pb-4 pt-6 px-6">Email</th>
                    <th class="pb-4 pt-6 px-6">Jenis PLP</th>
                    <th class="pb-4 pt-6 px-6">Nilai</th>
                    <th class="pb-4 pt-6 px-6">Rincian Nilai</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="mahasiswa in mahasiswas" :key="mahasiswa.id" class="hover:bg-gray-100">
                    <td class="border-t items-center px-6 py-4">
                        {{ mahasiswa.nim }}
                    </td>
                    <td class="border-t items-center px-6 py-4">
                        {{ mahasiswa.nama }}
                    </td>
                    <td class="border-t items-center px-6 py-4">
                        {{ mahasiswa.prodi }}
                    </td>
                    <td class="border-t items-center px-6 py-4">
                        {{ mahasiswa.email }}
                    </td>
                    <td class="border-t items-center px-6 py-4">
                        {{ setJenisPlp(mahasiswa.jenis_plp) }}
                    </td>
                    <td class="border-t items-center px-6 py-4">
                        {{ mahasiswa.nilai }}
                    </td>
                    <td v-if="user.role == 1" class="border-t items-center px-6 py-4">
                        <div class="flex flex-row space-x-4">
                            <DestroyButton @click="destroyAsosiasiMahasiswa(mahasiswa.id)"><i class="fa-solid fa-trash text-white"></i></DestroyButton>
                            <DetailButton @click="nilaiMahasiswa(mahasiswa.jenis_plp, mahasiswa.prodi, mahasiswa.id)"><i class="fa-solid fa-file-pen fa-lg"></i></DetailButton>
                        </div>
                    </td>
                    <td v-if="user.role == 2" class="border-t items-center px-6 py-4">
                        <div class="flex flex-row space-x-4">
                            <DetailButton @click="nilaiMahasiswa(mahasiswa.jenis_plp, mahasiswa.prodi, mahasiswa.id)"><i class="fa-solid fa-file-pen fa-lg"></i></DetailButton>
                        </div>
                    </td>
                </tr>
                <tr v-if="mahasiswas.length == 0">
                    <td class="px-6 py-4 text-center border-t" colspan="7">No data found.</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>