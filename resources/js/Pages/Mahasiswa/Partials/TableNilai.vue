<template>
    <div class="bg-white rounded-md shadow overflow-x-auto mt-10">
        <table class="w-full whitespace-nowrap">
            <thead>
                <tr class="text-left font-bold">
                    <th class="pb-4 pt-6 px-6">Nim</th>
                    <th class="pb-4 pt-6 px-6">Nama</th>
                    <th class="pb-4 pt-6 px-6">Nilai Komponen 1</th>
                    <th class="pb-4 pt-6 px-6">Nilai Komponen 2</th>
                    <th class="pb-4 pt-6 px-6">Nilai Komponen 3</th>
                    <th class="pb-4 pt-6 px-6">Nilai Komponen 4</th>
                    <th class="pb-4 pt-6 px-6">Nilai</th>
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
                        {{ mahasiswa.n_komponen_satu }}
                    </td>
                    <td class="border-t items-center px-6 py-4">
                        {{ mahasiswa.n_komponen_dua }}
                    </td>
                    <td class="border-t items-center px-6 py-4">
                        {{ mahasiswa.n_komponen_tiga }}
                    </td>
                    <td class="border-t items-center px-6 py-4">
                        {{ mahasiswa.n_komponen_empat }}
                    </td>
                    <td class="border-t items-center px-6 py-4">
                        {{ mahasiswa.nilai }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
<script>
import { onMounted, reactive } from 'vue'
import axios from 'axios';
import UpdateButton from '@/Components/UpdateButton.vue';
export default{
    components: { UpdateButton },
    props: {
        id: Number
    },
    setup(props){
        const mahasiswa = reactive({
            nim: '',
            nama: '',
            n_komponen_satu: '',
            n_komponen_dua: '',
            n_komponen_tiga: '',
            n_komponen_empat: '',
            nilai: ''
        })

        onMounted(() => {
            axios.get(`/getMahasiswaById/${props.id}`)
            .then((res) => {
                mahasiswa.nim = res.data.data.nim
                mahasiswa.nama = res.data.data.nama
                mahasiswa.n_komponen_satu = res.data.data.n_komponen_satu
                mahasiswa.n_komponen_dua = res.data.data.n_komponen_dua
                mahasiswa.n_komponen_tiga = res.data.data.n_komponen_tiga
                mahasiswa.n_komponen_empat = res.data.data.n_komponen_empat
                mahasiswa.nilai = res.data.data.nilai
            })
            .catch((err) => {
                console.log(err)
            })
        })

        return {
            mahasiswa
        }
    }
}
</script>