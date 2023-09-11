<script setup>
import { onMounted } from 'vue'
import axios from 'axios';

const props = defineProps({
    id: Number
})

onMounted(() => {
    getMahasiswaByIdMahasiswa ()
})

const getMahasiswaByIdMahasiswa = () => {
    axios.get(`/getMahasiswaByIdMahasiswa/${props.id}`)
    .then((res) => {
        console.log(res)
    })
    .catch((err) => {
        console.log(err)
    })
}
</script>
<template>

</template>