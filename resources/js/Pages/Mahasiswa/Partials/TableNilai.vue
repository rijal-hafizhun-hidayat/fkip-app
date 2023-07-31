<script setup>
import { onMounted, reactive } from 'vue'
import axios from 'axios';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const mahasiswa = reactive({
    nama: '',
    nim: '',
    nilai_nb: '',
    nilai_nc: '',
    nilai_nd: '',
    nilai_ne: '',
    nilai_ns: ''
})
const props = defineProps({
    id: Number,
    jenis_plp: String,
    jenis_bidang: String
})

console.log(props.jenis_plp, props.jenis_bidang, props.id)

onMounted(() => {
    getMahasiswaById()
})

const getMahasiswaById = () => {
    axios.get(`/getMahasiswaById/${props.id}`)
    .then((res) => {
        console.log(res)
        mahasiswa.nim = res.data.data.nim
        mahasiswa.nama = res.data.data.nama
        mahasiswa.nilai_nb = res.data.data.nilai_nb
        mahasiswa.nilai_nc = res.data.data.nilai_nc
        mahasiswa.nilai_nd = res.data.data.nilai_nd
        mahasiswa.nilai_ne = res.data.data.nilai_ne
        mahasiswa.nilai_ns = res.data.data.nilai_ns
        mahasiswa.nilai = res.data.data.nilai
    })
    .catch((err) => {
        console.log(err)
    })
}
</script>
<template>
    <div class="bg-white rounded-md shadow overflow-x-auto mt-3">
        <!-- <div><h2 class="font-semibold text-xl text-gray-800 ml-6">Detail Nilai Mahasiswa</h2></div> -->
        <table class="w-full whitespace-nowrap">
            <thead>
                <tr class="text-left font-bold">
                    <th class="pb-4 pt-6 px-6">Nim</th>
                    <th class="pb-4 pt-6 px-6">Nama</th>
                    <th class="pb-4 pt-6 px-6">Ns</th>
                    <th class="pb-4 pt-6 px-6">Nb</th>
                    <th v-if="jenis_bidang == 'teaching' || jenis_bidang == 'bk'" class="pb-4 pt-6 px-6">Nc</th>
                    <th v-if="jenis_bidang == 'pgpaud' || jenis_bidang == 'bk'" class="pb-4 pt-6 px-6">Nd</th>
                    <th v-if="jenis_bidang == 'bk'" class="pb-4 pt-6 px-6">Ne</th>
                    <th class="pb-4 pt-6 px-6">Nilai Total</th>
                </tr>
            </thead>
            <tbody>
                <tr class="hover:bg-gray-100">
                    <td class="border-t items-center px-6 py-4">
                        {{ mahasiswa.nim }}
                    </td>
                    <td class="border-t items-center px-6 py-4">
                        {{ mahasiswa.nama }}
                    </td>
                    <td class="border-t items-center px-6 py-4">
                        {{ mahasiswa.nilai_ns }}
                    </td>
                    <td class="border-t items-center px-6 py-4">
                        {{ mahasiswa.nilai_nb }}
                    </td>
                    <td v-if="jenis_bidang == 'teaching' || jenis_bidang == 'bk'" class="border-t items-center px-6 py-4">
                        {{ mahasiswa.nilai_nc }}
                    </td>
                    <td v-if="jenis_bidang == 'pgpaud' || jenis_bidang == 'bk'" class="border-t items-center px-6 py-4">
                        {{ mahasiswa.nilai_nd }}
                    </td>
                    <td v-if="jenis_bidang == 'bk'" class="border-t items-center px-6 py-4">
                        {{ mahasiswa.nilai_ne }}
                    </td>
                    <td class="border-t items-center px-6 py-4">
                        {{ mahasiswa.nilai }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>