<script setup>
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { ref, onMounted } from 'vue'
import axios from 'axios';
import { router } from '@inertiajs/vue3'
import Swal from 'sweetalert2';

const validation = ref([])
const namaSekolah = ref('')
const props = defineProps({
    id: Number
})

onMounted(() => {
    getSekolahById()
})

const getSekolahById = () => {
    axios.get(`/getSekolahById/${props.id}`)
    .then((res) => {
        namaSekolah.value = res.data.data.nama
    })
    .catch((err) => {
        console.log(err)
    })
}

const submit = () =>{
    axios.put(`/sekolah/${props.id}`, {
        nama: namaSekolah.value
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
        console.log(err)
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
                v-model="namaSekolah" />
            <InputError v-if="validation.nama" :message="validation.nama[0]" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <PrimaryButton>Save</PrimaryButton>
        </div>
    </form>
</template>