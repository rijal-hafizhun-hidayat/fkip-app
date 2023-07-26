<script setup>
import DestroyButton from '@/Components/DestroyButton.vue';
import UpdateButton from '@/Components/UpdateButton.vue';
import { router } from '@inertiajs/vue3';
import axios from 'axios';
import { onMounted, ref } from 'vue'
import nprogress from 'nprogress';
import Swal from 'sweetalert2';

const sekolahs = ref([])

onMounted(() => {
    getSekolah()
})

const getSekolah = () => {
    axios.get('/getSekolah')
    .then((res) => {
        sekolahs.value = res.data.data
    })
    .catch((err) => {
        console.log(err)
    })
}

const destroy = (id) => {
    nprogress.start()
    axios.delete(`/sekolah/${id}`)
    .then((res) => {
        Swal.fire({
            icon: 'success',
            title: res.data.title,
            text: res.data.text
        })
        router.get('/sekolah')
    })
    .catch((err) => {
        console.log(err)
    })
    .finally(() => {
        nprogress.done()
    })
}

const show = (id) => {
    router.get(`/sekolah/${id}`)
}
</script>
<template>
    <div class="bg-white rounded-md shadow overflow-x-auto mt-10">
        <table class="w-full whitespace-nowrap">
            <thead>
                <tr class="text-left font-bold">
                    <th class="pb-4 pt-6 px-6">Nama Sekolah</th>
                    <th class="pb-4 pt-6 px-6">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="sekolah in sekolahs.data" :key="sekolah.id" class="hover:bg-gray-100">
                    <td class="border-t items-center px-6 py-4">
                        {{ sekolah.nama }}
                    </td>
                    <td class="border-t items-center px-6 py-4">
                        <div class="flex flex-row space-x-4">
                            <DestroyButton @click="destroy(sekolah.id)"><i class="fa-solid fa-trash text-white"></i></DestroyButton>
                            <UpdateButton @click="show(sekolah.id)"><i class="fa-solid fa-pen-to-square text-white"></i></UpdateButton>
                        </div>
                    </td>
                </tr>
                <!-- <tr v-if="length === 0">
                    <td class="px-6 py-4 text-center border-t" colspan="5">No data found.</td>
                </tr> -->
            </tbody>
        </table>
    </div>
</template>