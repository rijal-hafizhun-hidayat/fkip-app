<script setup>
import InputLabel from '@/Components/InputLabel.vue';
import NProgress from 'nprogress';
import axios from 'axios';
import { reactive, ref } from 'vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputError from '@/Components/InputError.vue';
import Swal from 'sweetalert2';
import { router } from '@inertiajs/vue3'

const form = reactive({
    excel: ''
})
const validation = ref([])

const submit = () => {
    NProgress.start()
    axios.post('/guru-pamong/import', {
        excel: form.excel
    }, {
        headers: {
            'Content-Type': 'multipart/form-data'
        }
    })
    .then((res) => {
        Swal.fire({
            icon: 'success',
            title: res.data.title,
            text: res.data.text
        })

        router.get('/guru-pamong')
    })
    .catch((err) => {
        validation.value = err.response.data.errors
    })
    .finally(() => {
        NProgress.done()
    })
}
</script>
<template>
    <form @submit.prevent="submit" class="mt-6 space-y-6">
        <div>
            <InputLabel for="excel" value="Import File Excel"/>
            <input @input="form.excel = $event.target.files[0]" class="mt-3 border-rose-600" type="file" id="excel">
            <InputError class="mt-4" v-if="validation.excel" :message="validation.excel[0]"/>
        </div>
       
        <div class="flex items-center gap-4">
            <PrimaryButton>Import</PrimaryButton>
        </div>
    </form>
</template>