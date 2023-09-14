<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Multiselect from 'vue-multiselect'
import 'vue-multiselect/dist/vue-multiselect.css'
import { ref, onMounted } from 'vue';
import axios from 'axios';
import Swal from 'sweetalert2';
import { router } from '@inertiajs/vue3'

const validation = ref([])
const dpl = ref([])
const guruPamong = ref([])
const isHidden = ref(true)
const asosiasi_id = ref('')
const props = defineProps({
    id: Number,
    jenisAsosiasi: Number,
    keterangan: String
})

onMounted(() => {
    getGuruPamongs()
    getDpl()
})

const getGuruPamongs = () => {
    axios.get('/getGuruPamongsIsNull')
    .then((res) => {
        guruPamong.value = res.data.data
    })
    .catch((err) => {
        console.log(err)
    })
}

const getDpl = () => {
    axios.get('/getDpl')
    .then((res) => {
        dpl.value = res.data.data
    })
    .catch((err) => {
        console.log(err)
    })
}


const showModal = () => {
    isHidden.value = !isHidden.value
}

const submit = () => {
    axios.put(`/storeAsosiasi/${props.id}`, {
        asosiasi_id: asosiasi_id.value.id,
        jenis_asosiasi: props.jenisAsosiasi
    })
    .then((res) => {
        Swal.fire({
            icon: 'success',
            title: res.data.title,
            text: res.data.text
        })

        router.get('/dashboard')
    })
    .catch((err) => {
        if(err.response.data.errors){
            validation.value = err.response.data.errors
        }
        else{
            Swal.fire({
                icon: 'error',
                title: err.response.data.title,
                text: err.response.data.text
            })

            router.get('/dashboard')
        }
    })
}

const nameGuruPamongWithLang = ({nama, bidang_keahlian}) => {
    return `${nama} - ${bidang_keahlian}`
}

const nameDplWithLang = ({nama, prodi}) => {
    return `${nama} - ${prodi}`
}
</script>
<template>
    <PrimaryButton @click="showModal">{{ keterangan }}</PrimaryButton>

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
                <form @submit.prevent="submit" class="px-3 space-y-6">

                    <div v-if="jenisAsosiasi == 3">
                        <InputLabel for="id_guru_pamong" value="Data Guru Pamong" />
                        <Multiselect v-model="asosiasi_id" :custom-label="nameGuruPamongWithLang" :options="guruPamong" required></Multiselect>
                        <InputError v-if="validation.asosiasi_id" :message="validation.asosiasi_id[0]" class="mt-2" />
                    </div>

                    <div v-else-if="jenisAsosiasi == 2">
                        <InputLabel for="id_dpl" value="Data Dpl" />
                        <Multiselect v-model="asosiasi_id" :custom-label="nameDplWithLang" :options="dpl" required></Multiselect>
                        <InputError v-if="validation.asosiasi_id" :message="validation.asosiasi_id[0]" class="mt-2" />
                    </div>

                    <div class="flex justify-end">
                        <PrimaryButton class="mt-5">Submit</PrimaryButton>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>