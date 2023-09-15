<script setup>
import { ref, reactive, onMounted } from 'vue'
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import SelectInput from '@/Components/SelectInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { router } from '@inertiajs/vue3';
import axios from 'axios';
import NProgress from 'nprogress';
import Swal from 'sweetalert2'
import Multiselect from 'vue-multiselect'
import 'vue-multiselect/dist/vue-multiselect.css'

const validation = ref([])
const props = defineProps({
    id: Number,
    prodis: Object,
    sekolahs: Object
})

const form = reactive({
    nama: '',
    asal_sekolah: '',
    bidang_keahlian: ''
})

onMounted(() =>{
    axios.get(`/getGuruPamongById/${props.id}`)
    .then((res) => {
        form.nama = res.data.data.nama
        form.asal_sekolah = res.data.data.asal_sekolah
        form.bidang_keahlian = res.data.data.bidang_keahlian
    })
    .catch((err) => {
        console.log(err)
    })
})

const submit = () => {
    NProgress.start()
    axios.put(`/guru-pamong/${props.id}`, {
        nama: form.nama,
        asal_sekolah: form.asal_sekolah.nama,
        bidang_keahlian: form.bidang_keahlian
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
        console.log(err.data.response.errors)
    })
    .finally(() => {
        NProgress.done()
    })
}

const nameWithLang = ({nama}) => {
    return nama
}
</script>
<template>
    <form @submit.prevent="submit" class="mt-6 space-y-6">
        <div>
            <InputLabel for="nama" value="Nama" />
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
            <InputLabel for="asal_sekolah" value="Asal Sekolah" />
            <Multiselect
                v-model="form.asal_sekolah"
                :custom-label="nameWithLang"
                :options="sekolahs">
            </Multiselect>
        </div>

        <div>
            <InputLabel for="bidang_keahlian" value="Bidang Keahlian"/>
            <SelectInput class="mt-1 blobk w-full" v-model="form.bidang_keahlian" :class="{ 'border-rose-600': validation.keahlian }">
                <option selected disabled value="">-- Pilih --</option>
                <option v-for="prodi in prodis">{{ prodi.bidang_keahlian }}</option>
            </SelectInput>
            <InputError v-if="validation.bidang_keahlian" :message="validation.keahlian[0]" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <PrimaryButton>Save</PrimaryButton>
        </div>
    </form>
</template>