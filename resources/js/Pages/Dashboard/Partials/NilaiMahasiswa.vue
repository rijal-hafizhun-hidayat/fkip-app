<script setup>
import { onMounted, ref } from 'vue'
import axios from 'axios';

const mahasiswa = ref([])
const props = defineProps({
    id_mahasiswa: Number
})

onMounted(() => {
    getNilai()
})

const getNilai = () => {
    axios.get(`/getNilai/${props.id_mahasiswa}`)
    .then((res) => {
        mahasiswa.value = res.data.data
    })
    .catch((err) => {
        console.log(err)
    })
}
</script>
<template>
    <div class="bg-white mt-10 px-4 py-6 rounded shadow-md">
        <p>Nilai PLP Anda: {{ mahasiswa.nilai }}</p>
        <p class="mt-4">Jika Terdapat Kesalahan Nilai Bisa Konfirmasi Guru Pamong</p>
    </div>
</template>