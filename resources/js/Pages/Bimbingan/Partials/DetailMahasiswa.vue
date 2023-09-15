<script setup>
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import { reactive, onMounted } from 'vue';

const props = defineProps({
    id: Number
})
const mahasiswa = reactive({
    nama: '',
    nim: '',
    jenis_plp: ''
})

onMounted(() => {
    getMahasiswaById()
})

const getMahasiswaById = () => {
    axios.get(`/getMahasiswaById/${props.id}`)
    .then((res) => {
        mahasiswa.nim = res.data.data.nim
        mahasiswa.nama = res.data.data.nama
        mahasiswa.jenis_plp = res.data.data.jenis_plp
    })
    .catch((err) => {
        console.log(err)
    })
}

const setJenisPlp = (jenisPlp) => {
    if(jenisPlp == 'plp_1'){
        jenisPlp = 'PLP 1'
    }
    else if(jenisPlp == 'plp_2'){
        jenisPlp = 'PLP 2'
    }
    else if(jenisPlp == 'km_plp_1'){
        jenisPlp = 'Kampus Mengajar PLP 1'
    }
    else if(jenisPlp == 'km_plp_2'){
        jenisPlp = 'Kampus Mengajar PLP 2'
    }

    return jenisPlp
}
</script>
<template>
    <div class="bg-white rounded-md shadow overflow-x-auto py-8 px-10 mt-10">
        <div class="flex">
            <InputLabel for="nama" class="basis-1/4 mt-3" value="Nama" />
            <TextInput
                disabled
                id="nama"
                type="text"
                class="mt-1 block w-full bg-slate-200" 
                v-model="mahasiswa.nama"/>
        </div>

        <div class="flex">
            <InputLabel for="nim" class="basis-1/4 mt-5" value="Nim" />
            <TextInput
                disabled
                id="nim"
                type="text"
                class="mt-3 block w-full bg-slate-200"
                v-model="mahasiswa.nim"/>
        </div>
        
        <div class="flex">
            <InputLabel for="jenis_plp" class="basis-1/4 mt-5" value="Jenis Plp" />
            <TextInput
                disabled
                id="nim"
                type="text"
                class="mt-3 block w-full bg-slate-200"
                :value="setJenisPlp(mahasiswa.jenis_plp)"/>
        </div>   
    </div>
</template>