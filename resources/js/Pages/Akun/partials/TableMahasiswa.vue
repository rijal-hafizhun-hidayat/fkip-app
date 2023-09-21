<script setup>
import { onMounted, ref } from 'vue'
import axios from 'axios';

const mahasiswa = ref([])
const props = defineProps({
    id: Number
})

onMounted(() => {
    getMahasiswaByIdMahasiswa ()
})

const getMahasiswaByIdMahasiswa = () => {
    axios.get(`/getMahasiswaByIdMahasiswa/${props.id}`)
    .then((res) => {
        console.log(res.data)
        //console.log(res.data.data)
        mahasiswa.value = res.data
    })
    .catch((err) => {
        console.log(err)
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
</script>
<template>
    <div class="bg-white rounded-md shadow overflow-x-auto mt-10">
        <table class="w-full whitespace-nowrap">
            <thead>
                <tr class="text-left font-bold">
                    <th class="pb-4 pt-6 px-6">Nim</th>
                    <th class="pb-4 pt-6 px-6">Nama</th>
                    <th class="pb-4 pt-6 px-6">Jenis PLP</th>
                    <th class="pb-4 pt-6 px-6">Prodi</th>
                </tr>
            </thead>
            <tbody>
                <tr v-if="mahasiswa.data" class="hover:bg-gray-100">
                    <td class="border-t items-center px-6 py-4">
                        {{ mahasiswa.data.nim }}
                    </td>
                    <td class="border-t items-center px-6 py-4">
                        {{ mahasiswa.data.nama }}
                    </td>
                    <td class="border-t items-center px-6 py-4">
                        {{ setJenisPlp(mahasiswa.data.jenis_plp) }}
                    </td>
                    <td class="border-t items-center px-6 py-4">
                        {{ mahasiswa.data.prodi }}
                    </td>
                </tr>
                <tr v-if="length == 0">
                    <td class="px-6 py-4 text-center border-t" colspan="8">No data found</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>