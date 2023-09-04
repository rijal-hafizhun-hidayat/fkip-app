<script setup>
import { reactive, onMounted } from 'vue'
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import axios from 'axios';
import nprogress from 'nprogress';
const props = defineProps({
    id: Number,
    jenis_plp: String,
    prodi: String
})
const form = reactive({
    nama: '',
    nim: ''
})

console.log(props.id)

onMounted(() => {
    getMahasiswaById()
})

const getMahasiswaById = () => {
    nprogress.start()
    axios.get(`/getMahasiswaById/${props.id}`)
    .then((res) => {
        form.nama = res.data.data.nama
        form.nim = res.data.data.nim
        form.prodi = res.data.data.prodi
    })
    .catch((err) => {
        console.log(err)
    })
    .finally(() => {
        nprogress.done()
    })
}

</script>
<template>
    <div class="bg-white rounded-md py-5 px-8 shadow overflow-x-auto mt-10">
        <div class="flex">
            <InputLabel for="nama" class="basis-1/4 mt-3" value="Nama" />
            <TextInput
                disabled
                id="nama"
                type="text"
                class="mt-1 block w-full bg-slate-200"
                v-model="form.nama"
            />
        </div>

        <div class="flex">
            <InputLabel for="nim" class="basis-1/4 mt-5" value="Nim" />
            <TextInput
                disabled
                id="nim"
                type="text"
                class="mt-3 block w-full bg-slate-200"
                v-model="form.nim"
            />
        </div>
        <div class="flex">
            <InputLabel for="prodi" class="basis-1/4 mt-5" value="Prodi" />
            <TextInput
                disabled
                id="nim"
                type="text"
                class="mt-3 block w-full bg-slate-200"
                v-model="form.prodi"
            />
        </div>
    </div>
</template>