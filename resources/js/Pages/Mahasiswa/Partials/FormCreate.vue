<script setup>
import { ref, reactive } from 'vue'
import axios from 'axios';
import NProgress from 'nprogress';
import Swal from 'sweetalert2'
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import SelectInput from '@/Components/SelectInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { router } from '@inertiajs/vue3'

const validation = ref([])
const form = reactive({
    nama: '',
    nim: '',
    prodi: '',
    jenis_plp: ''
})
const props = defineProps({
    prodis: Object
})

const submit = () => {
    //console.log(form)
    NProgress.start()
    axios.post('/mahasiswa', {
        nama: form.nama,
        nim: form.nim,
        prodi: form.prodi,
        jenis_plp: form.jenis_plp
    })
    .then((res) => {
        Swal.fire({
            icon: 'success',
            title: res.data.title,
            text: res.data.text
        })
        router.get('/mahasiswa')
    })
    .catch((err) => {
        validation.value = err.response.data.errors
    })
    .finally(() => {
        NProgress.done()
    })
}

const numOnly = (evt) => {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 46) {
        evt.preventDefault();
    } else {
        return true;
    }
}
</script>
<template>
     <form @submit.prevent="submit" class="mt-6 space-y-6">
        <div>
            <InputLabel for="nama" value="Nama Mahasiswa" />
                <TextInput
                    id="nama"
                    ref="nama"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.nama"
                    :class="{ 'border-rose-600': validation.nama }"
                />
                <InputError v-if="validation.nama" :message="validation.nama[0]" class="mt-2" />
            </div>

            <div>
                <InputLabel for="nim" value="Nim" />
                <TextInput
                    id="nim"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.nim"
                    v-on:keypress="numOnly"
                    :class="{ 'border-rose-600': validation.nim }"
                />
                <InputError v-if="validation.nim" :message="validation.nim[0]" class="mt-2" />
            </div>

            <div>
                <InputLabel for="prodi" value="Prodi"/>
                <SelectInput class="mt-1 blobk w-full" v-model="form.prodi" :class="{ 'border-rose-600': validation.prodi }">
                    <option selected disabled value="">-- Pilih --</option>
                    <option v-for="prodi in prodis">{{ prodi.nama }}</option>
                </SelectInput>
                <InputError v-if="validation.prodi" :message="validation.prodi[0]" class="mt-2" />
            </div>

            <div>
                <InputLabel for="jenis_plp" value="PLP"/>
                <SelectInput class="mt-1 blobk w-full" v-model="form.jenis_plp" :class="{ 'border-rose-600': validation.jenis_plp }">
                    <option selected disabled value="">-- Pilih --</option>
                    <option value="plp_1">PLP 1</option>
                    <option value="plp_2">PLP 2</option>
                </SelectInput>
                <InputError v-if="validation.jenis_plp" :message="validation.jenis_plp[0]" class="mt-2" />
            </div>

            <div class="flex items-center gap-4">
                <PrimaryButton>Save</PrimaryButton>
            </div>
        </form>
</template>