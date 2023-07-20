<script setup>
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputError from '@/Components/InputError.vue';
import Multiselect from 'vue-multiselect'
import 'vue-multiselect/dist/vue-multiselect.css'
import { onMounted, reactive, ref } from 'vue'
import axios from 'axios';
import Swal from 'sweetalert2';
import { router } from '@inertiajs/vue3'

const validation = ref([])
const props = defineProps({
    id: Number,
    dpls: Object
})
const mahasiswa = reactive({
    nama: '',
    nim: '',
    prodi: '',
    id_dpl: ''
})

onMounted(() => {
    getMahasiswaById()
})

const nameWithLang = ({nama, prodi}) => {
    return `${nama} — ${prodi}`
}

const getMahasiswaById = () => {
    axios.get(`/getMahasiswaById/${props.id}`)
    .then((res) => {
        mahasiswa.nama = res.data.data.nama
        mahasiswa.nim = res.data.data.nim
        mahasiswa.prodi = res.data.data.prodi
    })
    .catch((err) => {
        console.log(err)
    })
}

const submit = () => {
    axios.put(`/updateIdDpl/${props.id}`, {
        nama: mahasiswa.nama,
        nim: mahasiswa.nim,
        prodi: mahasiswa.prodi,
        id_dpl: mahasiswa.id_dpl.id
    })
    .then((res) => {
        Swal.fire({
            icon: 'success',
            title: res.data.title,
            text: res.data.text
        })
        router.get(`/mahasiswa/dpl/${props.id}`)
    })
    .catch((err) => {
        validation.value = err.response.data.errors
    })
}
</script>
<template>
    <div class="bg-white py-8 px-10 mt-10 rounded-md shadow-md">
        <form @submit.prevent="submit" class="space-y-6">
            <div class="flex">
                <InputLabel for="nama" class="basis-1/4 mt-3" value="Nama" />
                <TextInput
                    disabled
                    id="nama"
                    type="text"
                    class="mt-1 block w-full bg-slate-200" 
                    v-model="mahasiswa.nama"/>
                <InputError v-if="validation.nama" :message="validation.nama[0]" class="mt-2" />
            </div>

            <div class="flex">
                <InputLabel for="nim" class="basis-1/4 mt-3" value="Nim" />
                <TextInput
                    disabled
                    id="nim"
                    type="text"
                    class="mt-1 block w-full bg-slate-200" 
                    v-model="mahasiswa.nim" />
                <InputError v-if="validation.nim" :message="validation.nim[0]" class="mt-2" />
            </div>

            <div class="flex">
                <InputLabel for="prodi" class="basis-1/4 mt-3" value="Prodi" />
                <TextInput
                    disabled
                    id="prodi"
                    type="text"
                    class="mt-1 block w-full bg-slate-200"
                    v-model="mahasiswa.prodi" />
                <InputError v-if="validation.prodi" :message="validation.prodi[0]" class="mt-2" />
            </div>
            
            <div class="flex">
                <InputLabel class="basis-1/4 mt-3" for="id_dpl" value="DPL"/>
                <Multiselect v-model="mahasiswa.id_dpl" :custom-label="nameWithLang" :options="dpls"></Multiselect>
                <InputError v-if="validation.id_dpl" :message="validation.id_dpl[0]" class="mt-2" />
            </div>
            <PrimaryButton>Submit</PrimaryButton>
        </form>
    </div>
</template>