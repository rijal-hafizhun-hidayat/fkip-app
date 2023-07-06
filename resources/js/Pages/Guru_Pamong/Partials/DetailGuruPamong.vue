<script setup>
import { reactive, onMounted } from 'vue';
import nprogress from 'nprogress';
import axios from 'axios';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';

const props = defineProps({
    id: Number
})

const form = reactive({
    nama: '',
    asal: '',
    asal_sekolah: ''
})

onMounted(() => {
    nprogress.start()
    axios.get(`/getGuruPamongById/${props.id}`)
    .then((res) => {
        form.nama = res.data.data.nama
        form.asal = res.data.data.asal
        form.asal_sekolah = res.data.data.asal_sekolah
    })
    .catch((err) => {
        console.log(err)
    })
    .finally(() => {
        nprogress.done()
    })
})
</script>
<template>
    <div class="flex">
        <InputLabel for="nama" class="basis-1/4 mt-3" value="Nama" />
        <TextInput
            disabled
            id="nipy"
            type="text"
            class="block w-full bg-slate-200"
            v-model="form.nama"
        />
    </div>
    <div class="flex">
        <InputLabel for="asal" class="basis-1/4 mt-7" value="Asal" />
        <TextInput
            disabled
            id="asal"
            type="text"
            class="mt-5 block w-full bg-slate-200"
            v-model="form.asal"
        />
    </div>
    <div class="flex">
        <InputLabel for="asal_sekolah" class="basis-1/4 mt-7" value="Asal Sekolah" />
        <TextInput
            disabled
            id="asal_sekolah"
            type="text"
            class="mt-5 block w-full bg-slate-200"
            v-model="form.asal_sekolah"
        />
    </div>
</template>