<script setup>
import { onMounted, reactive } from 'vue'
import axios from 'axios';

const mahasiswa = reactive({
    nama: '',
    nim: '',
    jenis_plp: '',
    nilai_nb: '',
    nilai_nc: '',
    nilai_nd: '',
    nilai_ne: '',
    nilai_ns: '',
    nilai_nf: '',
    nilai_ng: '',
    nilai_nv: '',
    nilai_na: ''
})
const props = defineProps({
    id: Number,
    jenis_plp: String,
    jenis_bidang: String
})

onMounted(() => {
    getMahasiswaById()
})

const getMahasiswaById = () => {
    axios.get(`/getMahasiswaById/${props.id}`)
    .then((res) => {
        mahasiswa.nim = res.data.data.nim
        mahasiswa.nama = res.data.data.nama
        mahasiswa.nilai_nb = res.data.data.nilai_nb
        mahasiswa.nilai_nc = res.data.data.nilai_nc
        mahasiswa.nilai_nd = res.data.data.nilai_nd
        mahasiswa.nilai_ne = res.data.data.nilai_ne
        mahasiswa.nilai_ns = res.data.data.nilai_ns
        mahasiswa.nilai_nf = res.data.data.nilai_nf
        mahasiswa.nilai_ng = res.data.data.nilai_ng
        mahasiswa.nilai_nv = res.data.data.nilai_nv
        mahasiswa.nilai_na = res.data.data.nilai_na
        mahasiswa.jenis_plp = res.data.data.jenis_plp
        mahasiswa.nilai = res.data.data.nilai
    })
    .catch((err) => {
        console.log(err)
    })
}
</script>
<template>
    <div class="bg-white rounded-md shadow overflow-x-auto mt-3">
        <table class="w-full whitespace-nowrap">
            <thead>
                <tr class="text-left font-bold">
                    <th class="pb-4 pt-6 px-6">Nim</th>
                    <th class="pb-4 pt-6 px-6">Nama</th>
                    <th v-if="(jenis_plp == 'plp_2' || jenis_plp == 'km_plp_2' || jenis_plp == 'am_plp_2')" class="pb-4 pt-6 px-6">Ns</th>
                    <th v-if="(jenis_plp == 'plp_1' || jenis_plp == 'km_plp_1')" class="pb-4 pt-6 px-6">Nb</th>
                    <th v-if="(jenis_plp == 'plp_2' || jenis_plp == 'km_plp_2' || jenis_plp == 'am_plp_2')" class="pb-4 pt-6 px-6">Nb</th>
                    <th v-if="(jenis_plp == 'plp_2' || jenis_plp == 'km_plp_2' || jenis_plp == 'am_plp_2') && jenis_bidang == 'bk'" class="pb-4 pt-6 px-6">Nc</th>
                    <th v-if="(jenis_plp == 'plp_2' || jenis_plp == 'km_plp_2' || jenis_plp == 'am_plp_2') && jenis_bidang == 'teaching'" class="pb-4 pt-6 px-6">Nc</th>
                    <th v-if="(jenis_plp == 'plp_2' || jenis_plp == 'km_plp_2' || jenis_plp == 'am_plp_2') && jenis_bidang == 'bk'" class="pb-4 pt-6 px-6">Nd</th>
                    <th v-if="(jenis_plp == 'plp_2' || jenis_plp == 'km_plp_2' || jenis_plp == 'am_plp_2') && jenis_bidang == 'pgpaud'" class="pb-4 pt-6 px-6">Nd</th>
                    <th v-if="(jenis_plp == 'plp_2' || jenis_plp == 'km_plp_2' || jenis_plp == 'am_plp_2') && jenis_bidang == 'bk'" class="pb-4 pt-6 px-6">Ne</th>
                    <th v-if="(jenis_plp == 'plp_2' || jenis_plp == 'km_plp_2' || jenis_plp == 'am_plp_2') && jenis_bidang == 'bk'" class="pb-4 pt-6 px-6">Nf</th>
                    <th v-if="(jenis_plp == 'plp_2' || jenis_plp == 'km_plp_2' || jenis_plp == 'am_plp_2') && jenis_bidang == 'bk'" class="pb-4 pt-6 px-6">Ng</th>
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
                    <td v-if="jenis_plp == 'plp_2' || jenis_plp == 'km_plp_2' || jenis_plp == 'am_plp_2'" class="border-t items-center px-6 py-4">
                        {{ mahasiswa.nilai_ns }}
                    </td>
                    <td v-if="jenis_plp == 'plp_1' || jenis_plp == 'km_plp_1'" class="border-t items-center px-6 py-4">
                        {{ mahasiswa.nilai_nb }}
                    </td>
                    <td v-if="jenis_plp == 'plp_2' || jenis_plp == 'km_plp_2' || jenis_plp == 'am_plp_2'" class="border-t items-center px-6 py-4">
                        {{ mahasiswa.nilai_nb }}
                    </td>
                    <td v-if="(jenis_plp == 'plp_2' || jenis_plp == 'km_plp_2' || jenis_plp == 'am_plp_2') && jenis_bidang == 'bk'" class="border-t items-center px-6 py-4">
                        {{ mahasiswa.nilai_nc }}
                    </td>
                    <td v-if="(jenis_plp == 'plp_2' || jenis_plp == 'km_plp_2' || jenis_plp == 'am_plp_2') && jenis_bidang == 'teaching'" class="border-t items-center px-6 py-4">
                        {{ mahasiswa.nilai_nc }}
                    </td>
                    <td v-if="(jenis_plp == 'plp_2' || jenis_plp == 'km_plp_2' || jenis_plp == 'am_plp_2') && jenis_bidang == 'bk'" class="border-t items-center px-6 py-4">
                        {{ mahasiswa.nilai_nd }}
                    </td>
                    <td v-if="(jenis_plp == 'plp_2' || jenis_plp == 'km_plp_2' || jenis_plp == 'am_plp_2') && jenis_bidang == 'pgpaud'" class="border-t items-center px-6 py-4">
                        {{ mahasiswa.nilai_nd }}
                    </td>
                    <td v-if="(jenis_plp == 'plp_2' || jenis_plp == 'km_plp_2' || jenis_plp == 'am_plp_2') && jenis_bidang == 'bk'" class="border-t items-center px-6 py-4">
                        {{ mahasiswa.nilai_ne }}
                    </td>
                    <td v-if="(jenis_plp == 'plp_2' || jenis_plp == 'km_plp_2' || jenis_plp == 'am_plp_2') && jenis_bidang == 'bk'" class="border-t items-center px-6 py-4">
                        {{ mahasiswa.nilai_nf }}
                    </td>
                    <td v-if="(jenis_plp == 'plp_2' || jenis_plp == 'km_plp_2' || jenis_plp == 'am_plp_2') && jenis_bidang == 'bk'" class="border-t items-center px-6 py-4">
                        {{ mahasiswa.nilai_ng }}
                    </td>
                    <td class="border-t items-center px-6 py-4">
                        {{ mahasiswa.nilai }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>