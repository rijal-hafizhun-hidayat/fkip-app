<script setup>
import InputLabel from '@/Components/InputLabel.vue';
import NProgress from 'nprogress';
import axios from 'axios';
import { reactive, ref } from 'vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputError from '@/Components/InputError.vue';
import SelectInput from '@/Components/SelectInput.vue';
import Swal from 'sweetalert2';
import { router } from '@inertiajs/vue3'

const routeApiImportAkun = ref('')
const form = reactive({
    jenis_akun: '',
    excel: ''
})

const validation = ref([])

const submit = () => {
    NProgress.start()
    axios.post(routeApiImportAkun.value, {
        excel: form.excel,
        jenis_akun: form.jenis_akun
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

        router.get('/akun')
    })
    .catch((err) => {
        validation.value = err.response.data.errors
    })
    .finally(() => {
        NProgress.done()
    })
}

const changeRouteApiImport = (jenisAkun) => {
    if(jenisAkun == 1){
        routeApiImportAkun.value = '/akun/import/dpl'
    }
    else if(jenisAkun == 2){
        routeApiImportAkun.value = '/akun/import/guru-pamong'
    }
    else{
        false
    }
}
</script>
<template>
    <form @submit.prevent="submit" class="mt-6 space-y-6">
        <div>
            <InputLabel for="jenis_akun" value="Jenis Akun" />
            <SelectInput
                class="mt-1 blobk w-full"
                v-model="form.jenis_akun"
                :class="{ 'border-rose-600': validation.jenis_akun }"
                @change="changeRouteApiImport(form.jenis_akun)">
                <option selected disabled value="">-- Pilih --</option>
                <option value="1">Dpl</option>
                <option value="2">Guru Pamong</option>
            </SelectInput>
            <InputError v-if="validation.jenis_akun" :message="validation.jenis_akun[0]" class="mt-2" />
        </div>

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