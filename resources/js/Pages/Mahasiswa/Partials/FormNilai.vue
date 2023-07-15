<script setup>
import { reactive, onMounted, ref } from 'vue'
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputLikertScale from '@/Components/InputLikertScale.vue'
import axios from 'axios';
import Swal from 'sweetalert2';
import { router } from '@inertiajs/vue3'

const validation = ref([])
const getMessageValidation = ref([])
const props = defineProps({
    id: Number
})
const form = reactive({
    nilai_kompeten: [],
})

// onMounted(() => {
//     axios.get(`/getMahasiswaById/${props.id}`)
//     .then((res) => {
//         form.nilai_kompeten = res.data.data.nilai_kompeten
//     })
//     .catch((err) => {
//         console.log(err)
//     })
// })

const submit = () => {
    axios.put(`/updateNilai/${props.id}`, {
        nilai_kompeten: form.nilai_kompeten,
    })
    .then((res) => {
        Swal.fire({
            icon: 'success',
            title: res.data.title,
            text: res.data.text
        })
        router.get(`/mahasiswa/nilai/${props.id}`)
    })
    .catch((err) => {
        console.log(err)
        validation.value = err.response.data.errors
    })
}
</script>
<template>
    <form @submit.prevent="submit" class="space-y-6">
        <div class="flex">
            <InputLabel for="n_kompeten_satu" class="basis-1/5 mt-3" value="Nilai Kompeten 1" />
            <InputLikertScale
                class="mt-2.5 block"
                :name="'n_kompeten_satu'"
                v-model="form.nilai_kompeten[0]"
                :class="{ 'border-rose-600': validation.nilai_kompeten }" />
            <InputError v-if="validation.nilai_kompeten" :message="validation.nilai_kompeten[0]" class="mt-3 ml-3" />
        </div>
        <div class="flex">
            <InputLabel for="n_kompeten_dua" class="basis-1/5 mt-3" value="Nilai Kompeten 2" />
            <InputLikertScale
                class="mt-2.5 block"
                :name="'n_kompeten_dua'"
                v-model="form.nilai_kompeten[1]"
                :class="{ 'border-rose-600': validation.nilai_kompeten }" />
            <InputError v-if="validation.nilai_kompeten" :message="validation.nilai_kompeten[0]" class="mt-3 ml-3" />
        </div>
        <div class="flex">
            <InputLabel for="n_kompeten_tiga" class="basis-1/5 mt-3" value="Nilai Kompeten 3" />
            <InputLikertScale
                class="mt-2.5 block"
                :name="'n_kompeten_tiga'"
                v-model="form.nilai_kompeten[2]"
                :class="{ 'border-rose-600': validation.nilai_kompeten }" />
            <InputError v-if="validation.nilai_kompeten" :message="validation.nilai_kompeten[0]" class="mt-3 ml-3" />
        </div>
        <div class="flex">
            <InputLabel for="n_kompeten_empat" class="basis-1/5 mt-3" value="Nilai Kompeten 4" />
            <InputLikertScale
                class="mt-2.5 block"
                :name="'n_kompeten_empat'"
                v-model="form.nilai_kompeten[3]"
                :class="{ 'border-rose-600': validation.nilai_kompeten }" />
            <InputError v-if="validation.nilai_kompeten" :message="validation.nilai_kompeten[0]" class="mt-3 ml-3" />
        </div>
        <div class="flex">
            <InputLabel for="n_kompeten_lima" class="basis-1/5 mt-3" value="Nilai Kompeten 5" />
            <InputLikertScale
                class="mt-2.5 block"
                :name="'n_kompeten_lima'"
                v-model="form.nilai_kompeten[4]"
                :class="{ 'border-rose-600': validation.nilai_kompeten }" />
            <InputError v-if="validation.nilai_kompeten" :message="validation.nilai_kompeten[0]" class="mt-3 ml-3" />
        </div>
        <PrimaryButton>Submit</PrimaryButton>
    </form>
</template>