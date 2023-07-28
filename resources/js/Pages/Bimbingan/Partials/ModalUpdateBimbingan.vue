<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import UpdateButton from '@/Components/UpdateButton.vue';
import { reactive, ref, onMounted, computed } from 'vue';
import axios from 'axios';
import Swal from 'sweetalert2';
import { router, usePage } from '@inertiajs/vue3'

const page = usePage()
const user = computed(() => page.props.auth.user)
const isHidden = ref(true)
const validation = ref([])
const props = defineProps({
    id: Number,
    id_mahasiswa: Number
})
const bimbingan = reactive({
    catatan_pembimbing: '',
    link: '',
    keterangan_bimbingan: ''
})

onMounted(() => {
    getBimbinganById()
})

const getBimbinganById = () => {
    axios.get(`/bimbingan/${props.id}`)
    .then((res) => {
        bimbingan.catatan_pembimbing = res.data.data.catatan_pembimbing
        bimbingan.link = res.data.data.link
        bimbingan.keterangan_bimbingan = res.data.data.keterangan_bimbingan
    })
    .catch((err) => {
        console.log(err)
    })
}

const submit = () => {
    axios.put(`/bimbingan/${props.id}`, {
        catatan_pembimbing: bimbingan.catatan_pembimbing,
        link: bimbingan.link,
        keterangan_bimbingan: bimbingan.keterangan_bimbingan  
    })
    .then((res) => {
        console.log(res)
        Swal.fire({
            icon: 'success',
            title: res.data.title,
            text: res.data.text
        })
        router.get(`/bimbingans/${props.id_mahasiswa}`)
    })
    .catch((err) => {
        console.log(err)
        Swal.fire({
            icon: 'error',
            title: err.response.data.title,
            text: err.response.data.text
        })
        router.get(`/bimbingans/${props.id_mahasiswa}`)
    })
}

const showModal = () => {
    isHidden.value = !isHidden.value
}
</script>
<template>
    <UpdateButton @click="showModal"><i class="fa-solid fa-pen-to-square text-white"></i></UpdateButton>

    <div :class="{ 'hidden': isHidden }" class="modal h-screen w-full fixed left-0 top-0 flex justify-center items-center bg-black bg-opacity-50">
        <div class="bg-white rounded shadow-lg sm:w-1/3">
            <!--- modal title -->
            <div class="flex justify-end px-6 ">
                <div class="mt-2">
                    <PrimaryButton @click="showModal"><i class="fa-solid fa-xmark text-white"></i></PrimaryButton>
                </div>
            </div>
            <!-- modal body -->
            <div class="p-3">
                <form @submit.prevent="submit" class="px-3 space-y-5">

                    <div v-if="user.role == 4">
                        <InputLabel for="keterangan_bimbingan" value="Keterangan Bimbingan" />
                        <TextInput
                            id="nama"
                            type="text"
                            class="block w-full"
                            v-model="bimbingan.keterangan_bimbingan"/>
                        <InputError v-if="validation.keterangan_bimbingan" :message="validation.keterangan_bimbingan[0]" class="mt-2" />
                    </div>

                    <div v-if="user.role == 4">
                        <InputLabel for="link" value="Link" />
                        <TextInput
                            id="matakuliah"
                            type="text"
                            class="block w-full"
                            v-model="bimbingan.link"/>
                        <InputError v-if="validation.link" :message="validation.link[0]" class="mt-2" />
                    </div>

                    <div v-if="user.role == 2">
                        <InputLabel for="catatan_pembimbing" value="catatan pembimbing" />
                        <TextInput
                            id="catatan_pembimbing"
                            type="text"
                            class="block w-full"
                            v-model="bimbingan.catatan_pembimbing"/>
                        <InputError v-if="validation.link" :message="validation.link[0]" class="mt-2" />
                    </div>

                    <div class="flex justify-end">
                        <PrimaryButton class="mt-5">Submit</PrimaryButton>
                    </div>

                </form>
            </div>
        </div>
    </div>
</template>