<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { reactive, ref } from 'vue';
import axios from 'axios';
import Swal from 'sweetalert2';

const isHidden = ref(true)
const validation = ref([])
const props = defineProps({
    id: Number
})
const form = reactive({
    keterangan_bimbingan: '',
    link: ''
})

const submit = () => {
    axios.put(`/bimbingan/${props.id}`, {
        keterangan_bimbingan: form.keterangan_bimbingan,
        link: form.link
    })
    .then((res) => {
        console.log(res)
    })
    .catch((err) => {
        if(err.response.data.text){
            Swal.fire({
                    icon: 'error',
                    title: err.response.data.title,
                    text: err.response.data.text
                })
        }
        else{
            validation.value = err.response.data.errors
        }
    })
}

const showModal = () => {
    isHidden.value = !isHidden.value
}
</script>
<template>
    <PrimaryButton @click="showModal">Tambah Bimbingan</PrimaryButton>

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
                <form @submit.prevent="submit" class="px-3">

                    <div class="mb-5">
                        <InputLabel for="keterangan_bimbingan" value="Keterangan Bimbingan" />
                        <TextInput
                            id="nama"
                            type="text"
                            class="mt-1 block w-full"
                            :class="{ 'border-rose-600': validation.keterangan_bimbingan }"
                            v-model="form.keterangan_bimbingan" />
                        <InputError v-if="validation.keterangan_bimbingan" :message="validation.keterangan_bimbingan[0]" class="mt-2" />
                    </div>

                    <div>
                        <InputLabel for="link" value="Link" />
                        <TextInput
                            id="matakuliah"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.link" 
                            :class="{ 'border-rose-600': validation.link }"/>
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