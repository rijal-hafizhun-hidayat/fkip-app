<script setup>
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SelectInput from '@/Components/SelectInput.vue';
import { ref, onMounted, reactive } from 'vue'
import axios from 'axios';
import { router } from '@inertiajs/vue3'
import Swal from 'sweetalert2';
import nprogress from 'nprogress';

const validation = ref([])
const form = reactive({
    nama: '',
    jenis_plp: ''
})
const props = defineProps({
    id: Number
})

onMounted(() => {
    getSekolahById()
})

const getSekolahById = () => {
    axios.get(`/getSekolahById/${props.id}`)
    .then((res) => {
        form.nama = res.data.data.nama
        form.jenis_plp = res.data.data.jenis_plp
    })
    .catch((err) => {
        console.log(err)
    })
}

const submit = () =>{
    nprogress.start()
    axios.put(`/sekolah/${props.id}`, {
        nama: form.nama,
        jenis_plp: form.jenis_plp
    })
    .then((res) => {
        Swal.fire({
            icon: 'success',
            title: res.data.title,
            text: res.data.text
        })
        router.get('/sekolah')
    })
    .catch((err) => {
        validation.value = err.response.data.errors
    })
    .finally(() => {
        nprogress.done()
    })
}
</script>
<template>
    <form @submit.prevent="submit" class="mt-6 space-y-6">
        <div>
            <InputLabel for="nama_sekolah" value="Nama Sekolah" />
            <TextInput
                id="nama_sekolah"
                type="text"
                class="mt-1 block w-full"
                :class="{ 'border-rose-600': validation.nama }"
                v-model="form.nama" />
            <InputError v-if="validation.nama" :message="validation.nama[0]" class="mt-2" />
        </div>

        <div>
            <InputLabel for="jenis_plp" value="Jenis Plp" />
            <SelectInput class="mt-1 blobk w-full" v-model="form.jenis_plp" :class="{ 'border-rose-600': validation.jenis_plp }">
                <option selected disabled value="">-- Pilih --</option>
                <option value="plp_1">PLP 1</option>
                <option value="plp_2">PLP 2</option>
            </SelectInput>
        </div>

        <div class="flex items-center gap-4">
            <PrimaryButton>Save</PrimaryButton>
        </div>
    </form>
</template>