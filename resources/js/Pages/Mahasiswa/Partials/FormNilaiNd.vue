<script setup>
import { reactive, onMounted, ref } from 'vue'
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputLikertScale from '@/Components/InputLikertScale.vue'
import axios from 'axios';
import Swal from 'sweetalert2';
import { router } from '@inertiajs/vue3'

const pertanyaans = ref([])
const props = defineProps({
    id: Number,
    jenis_plp: String,
    jenis_bidang: String,
    jenis_pertanyaan: String
})
const nilai = reactive({
    nilai_kompeten_nd: []
})

console.log(props.id, props.jenis_plp, props.jenis_bidang, props.jenis_pertanyaan)

onMounted(() => {
    getPertanyaanByJenisPlpJenisBidangJenisPertanyaan()
    getNilaiKomponenByIdMahasiswa()
})

const getNilaiKomponenByIdMahasiswa = () => {
    axios.get(`/getNilaiKomponenByIdMahasiswa/${props.jenis_plp}/${props.id}`)
    .then((res) => {
        if(res.data.data.nilai_kompeten_nd != null){
            nilai.nilai_kompeten_nd = JSON.parse(res.data.data.nilai_kompeten_nd)
        }
    })
    .catch((err) => {
        console.log(err)
    })
}

const getPertanyaanByJenisPlpJenisBidangJenisPertanyaan = () => {
    axios.get(`/getPertanyaanByJenisPlpJenisBidangJenisPertanyaan/${props.jenis_plp}/${props.jenis_bidang}/${props.jenis_pertanyaan}`)
    .then((res) => {
        pertanyaans.value = res.data.data
    })
    .catch((err) => {
        console.log(err)
    })
}

const submit = () => {
    axios.put(`/updateNilai/${props.id}`, {
        nilai_kompeten: nilai.nilai_kompeten_nd,
        jenis_nilai: 'nilai_nd',
        jenis_bidang: props.jenis_bidang,
        jenis_nilai_kompeten: 'nilai_kompeten_nd',
        jenis_plp: props.jenis_plp
    })
    .then((res) => {
        Swal.fire({
            icon: 'success',
            title: res.data.title,
            text: res.data.text
        })

        router.get(`/mahasiswa/nilai/${props.jenis_plp}/${props.jenis_bidang}/${props.id}`)
    })
    .catch((err) => {
        console.log(err)
    })
}
</script>
<template>
    <form @submit.prevent="submit" class="space-y-6">
        <div v-for="(pertanyaan, index) in pertanyaans" class="flex">
            <InputLabel :for="'n_kompeten_'+index+1" class="basis-1/2 mt-3" :value="pertanyaan.kalimat" />
            <InputLikertScale
                class="mt-2.5 block"
                :name="'n_kompeten_'+index+1"
                v-model="nilai.nilai_kompeten_nd[index]" />
        </div>
        <PrimaryButton>Submit</PrimaryButton>
    </form>
</template>