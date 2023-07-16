<script setup>
import { onMounted, reactive } from 'vue'
import axios from 'axios';
import UpdateButton from '@/Components/UpdateButton.vue';

const mahasiswa = reactive({
    nilai_kompeten_satu: '',
    nilai_kompeten_dua: '',
    nilai_kompeten_tiga: '',
    nilai_kompeten_empat: '',
    nilai_kompeten_lima: '',
    nilai_nb: ''
})
const props = defineProps({
    id: Number
})

onMounted(() => {
    let nilai_kompeten = ''
    axios.get(`/getNilaiMahasiswaByIdMahasiswa/${props.id}`)
    .then((res) => {
        console.log(res)
        nilai_kompeten = JSON.parse(res.data.data.nilai_kompeten)
        mahasiswa.nilai_kompeten_satu = nilai_kompeten[0]
        mahasiswa.nilai_kompeten_dua = nilai_kompeten[1]
        mahasiswa.nilai_kompeten_tiga = nilai_kompeten[2]
        mahasiswa.nilai_kompeten_empat = nilai_kompeten[3]
        mahasiswa.nilai_kompeten_lima = nilai_kompeten[4]
        mahasiswa.nilai_nb = res.data.data.nilai_nb
        // console.log(nilai_kompeten)
        // console.log(nilai_kompeten[1])
    })
    .catch((err) => {
        console.log(err)
    })
})
</script>
<template>
    <div class="bg-white rounded-md shadow overflow-x-auto mt-10">
        <table class="w-full whitespace-nowrap">
            <thead>
                <tr class="text-left font-bold">
                    <th class="pb-4 pt-6 px-6">Nilai Kompeten 1</th>
                    <th class="pb-4 pt-6 px-6">Nilai Kompeten 2</th>
                    <th class="pb-4 pt-6 px-6">Nilai Kompeten 3</th>
                    <th class="pb-4 pt-6 px-6">Nilai Kompeten 4</th>
                    <th class="pb-4 pt-6 px-6">Nilai Kompeten 5</th>
                    <th class="pb-4 pt-6 px-6">Nilai</th>
                </tr>
            </thead>
            <tbody>
                <tr class="hover:bg-gray-100">
                    <td class="border-t items-center px-6 py-4">
                        {{ mahasiswa.nilai_kompeten_satu }}
                    </td>
                    <td class="border-t items-center px-6 py-4">
                        {{ mahasiswa.nilai_kompeten_dua }}
                    </td>
                    <td class="border-t items-center px-6 py-4">
                        {{ mahasiswa.nilai_kompeten_tiga }}
                    </td>
                    <td class="border-t items-center px-6 py-4">
                        {{ mahasiswa.nilai_kompeten_empat }}
                    </td>
                    <td class="border-t items-center px-6 py-4">
                        {{ mahasiswa.nilai_kompeten_lima }}
                    </td>
                    <td class="border-t items-center px-6 py-4">
                        {{ mahasiswa.nilai_nb }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>