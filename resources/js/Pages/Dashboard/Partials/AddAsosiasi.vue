<script setup>
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Multiselect from 'vue-multiselect'
import 'vue-multiselect/dist/vue-multiselect.css'
import { reactive, ref, onMounted } from 'vue';
import axios from 'axios';
import Swal from 'sweetalert2';
import { router } from '@inertiajs/vue3'

const dpl = ref([])
const guruPamong = ref([])
const isHidden = ref(true)
const form = reactive({
    id_guru_pamong: '',
    id_dpl: ''
})
defineProps({
    asosiasi: String,
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
        console.log(res)
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
    axios.put()
    .then((res) => {
        console.log(res)
    })
    .catch((err) => {
        console.log(err)
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

                    <div v-if="asosiasi == 'guru-pamong'">
                        <InputLabel for="id_guru_pamong" value="Data Guru Pamong" />
                        <Multiselect v-model="form.id_guru_pamong" :custom-label="nameGuruPamongWithLang" :options="guruPamong"></Multiselect>
                    </div>

                    <div v-else-if="asosiasi == 'dpl'">
                        <InputLabel for="id_dpl" value="Data Dpl" />
                        <Multiselect v-model="form.id_dpl" :custom-label="nameDplWithLang" :options="dpl"></Multiselect>
                    </div>

                    <div class="flex justify-end">
                        <PrimaryButton class="mt-5">Submit</PrimaryButton>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>