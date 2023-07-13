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
const props = defineProps({
    id: Number
})
const form = reactive({
    n_komponen_satu: '',
    n_komponen_dua: '',
    n_komponen_tiga: '',
    n_komponen_empat: '',
    n_komponen_lima: ''
})

onMounted(() => {
    axios.get(`/getMahasiswaById/${props.id}`)
    .then((res) => {
        //console.log(res)
        form.n_komponen_satu = res.data.data.n_komponen_satu
        form.n_komponen_dua = res.data.data.n_komponen_dua
        form.n_komponen_tiga = res.data.data.n_komponen_tiga
        form.n_komponen_empat = res.data.data.n_komponen_empat
        form.n_komponen_lima = res.data.data.n_komponen_lima
    })
    .catch((err) => {
        console.log(err)
    })
})

const submit = () => {
    axios.put(`/updateNilai/${props.id}`, {
        n_komponen_satu: form.n_komponen_satu,
        n_komponen_dua: form.n_komponen_dua,
        n_komponen_tiga: form.n_komponen_tiga,
        n_komponen_empat: form.n_komponen_empat,
        n_komponen_lima: form.n_komponen_lima,
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
        validation.value = err.response.data.errors
    })
}
</script>
<template>
    <form @submit.prevent="submit" class="space-y-6">
        <div class="flex">
            <InputLabel for="n_komponen_satu" class="basis-1/5 mt-3" value="Nilai Komponen 1" />
            <InputLikertScale
                class="mt-2.5 block"
                :name="'n_komponen_satu'"
                v-model="form.n_komponen_satu"
                :class="{ 'border-rose-600': validation.n_komponen_satu }"
            />
            <InputError v-if="validation.n_komponen_satu" :message="validation.n_komponen_satu[0]" class="mt-3 ml-3" />
        </div>
        <div class="flex">
            <InputLabel for="n_komponen_dua" class="basis-1/5 mt-3" value="Nilai Komponen 2" />
            <InputLikertScale
                class="mt-2.5 block"
                :name="'n_komponen_dua'"
                v-model="form.n_komponen_dua"
                :class="{ 'border-rose-600': validation.n_komponen_dua }"
            />
            <InputError v-if="validation.n_komponen_dua" :message="validation.n_komponen_dua[0]" class="mt-3 ml-3" />
        </div>
        <div class="flex">
            <InputLabel for="n_komponen_tiga" class="basis-1/5 mt-3" value="Nilai Komponen 3" />
            <InputLikertScale
                class="mt-2.5 block"
                :name="'n_komponen_tiga'"
                v-model="form.n_komponen_tiga"
                :class="{ 'border-rose-600': validation.n_komponen_tiga }"
            />
            <InputError v-if="validation.n_komponen_tiga" :message="validation.n_komponen_tiga[0]" class="mt-3 ml-3" />
        </div>
        <div class="flex">
            <InputLabel for="n_komponen_empat" class="md:basis-1/5 mt-3" value="Nilai Komponen 4" />
            <InputLikertScale
                class="mt-2.5 block"
                :name="'n_komponen_empat'"
                v-model="form.n_komponen_empat"
                :class="{ 'border-rose-600': validation.n_komponen_empat }"
            />
            <InputError v-if="validation.n_komponen_empat" :message="validation.n_komponen_empat[0]" class="mt-3 ml-3" />
        </div>
        <div class="flex">
            <InputLabel for="n_komponen_lima" class="md:basis-1/5 mt-3" value="Nilai Komponen 5" />
            <InputLikertScale
                class="mt-2.5 block"
                :name="'n_komponen_lima'"
                v-model="form.n_komponen_lima"
                :class="{ 'border-rose-600': validation.n_komponen_lima }"
            />
            <InputError v-if="validation.n_komponen_lima" :message="validation.n_komponen_lima[0]" class="mt-3 ml-3" />
        </div>
        <PrimaryButton>Submit</PrimaryButton>
    </form>
</template>