<script setup>
import { ref, reactive, onMounted } from 'vue'
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { router } from '@inertiajs/vue3';
import axios from 'axios';
import Multiselect from 'vue-multiselect'
import 'vue-multiselect/dist/vue-multiselect.css'
import Swal from 'sweetalert2'

const mahasiswa = ref([])
const form = reactive({
    nama: '',
    asal: '',
    id_mahasiswa: ''
})
const props = defineProps({
    id: Number
})

onMounted(() => {
    getGuruPamongById(props.id)
    getMahasiswa()
})

const getGuruPamongById = (id) => {
    axios.get(`/getGuruPamongById/${id}`)
    .then((res) => {
        form.nama = res.data.data.nama
        form.asal_sekolah = res.data.data.asal_sekolah
    })
    .catch((err) => {
        console.log(err)
    })
}

const getMahasiswa = () => {
    axios.get('/getMahasiswaIsNull')
    .then((res) => {
        console.log(res)
        mahasiswa.value = res.data.data
    })
    .catch((err) => {
        console.log(err)
    })
}

const submit = () => {
    axios.put(`/storeAsosiasiMahasiswa/${props.id}`, {
        id_mahasiswa: form.id_mahasiswa.id
    })
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

const nameWithLang = ({nama}) => {
    return nama
}
</script>
<template>
    <form @submit.prevent="submit" class="space-y-6">
        <div class="flex">
            <InputLabel for="ama" class="basis-1/4 mt-3" value="Nama" />
            <TextInput
                disabled
                id="nipy"
                type="text"
                class="mt-1 block w-full bg-slate-200"
                v-model="form.nama"
            />
        </div>

        <div class="flex">
            <InputLabel for="asal_sekolah" class="basis-1/4 mt-3" value="Asal Sekolah" />
            <TextInput
                disabled
                id="asal_sekolah"
                type="text"
                class="mt-1 block w-full bg-slate-200"
                v-model="form.asal_sekolah"
            />
        </div>
        <div class="flex">
            <InputLabel class="basis-1/4 mt-3" for="id_mahasiswa" value="Mahasiswa"/>
            <Multiselect
                v-model="form.id_mahasiswa"
                :custom-label="nameWithLang"
                :options="mahasiswa">
            </Multiselect>
        </div>
        <PrimaryButton>Submit</PrimaryButton>
    </form>
</template>