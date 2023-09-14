<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import SelectInput from '@/Components/SelectInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DetailButton from '@/Components/DetailButton.vue';
import { ref } from 'vue';
import axios from 'axios';
import Swal from 'sweetalert2';
import { router } from '@inertiajs/vue3'

const props = defineProps({
    id: Number,
    id_mahasiswa: Number
})

const confirm = ref()
const isHidden = ref(true)
const showModal = () => {
    isHidden.value = !isHidden.value
}

const submit = () => {
    axios.put(`/bimbingan/confirmed/${props.id}`, {
        confirmed: confirm.value
    })
    .then((res) => {
        Swal.fire({
            icon: 'success',
            title: res.data.title,
            text: res.data.text
        })

        router.get(`/bimbingans/${props.id_mahasiswa}`)
    })
    .catch((err) => {
        console.log(err)
    })
}
</script>
<template>
    <DetailButton @click="showModal"><i class="fa-solid fa-square-check fa-lg"></i></DetailButton>

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
                <form @submit.prevent="submit()" class="px-3 space-y-6">
                    <div>
                        <InputLabel for="catatan_pembimbing" value="catatan_pembimbing" />
                        <SelectInput v-model="confirm" class="block w-full">
                            <option selected disabled value="">-- Pilih --</option>
                            <option value="2">ACC</option>
                            <option value="1">Revisi</option>
                            <option value="3">Di Tolak</option>
                        </SelectInput>
                        <!-- <InputError v-if="validation.email" :message="validation.email[0]" /> -->
                    </div>

                    <div class="flex justify-end">
                        <PrimaryButton class="mt-5">Submit</PrimaryButton>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>