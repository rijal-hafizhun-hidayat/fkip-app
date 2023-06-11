<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <div><h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2></div>
                <!-- <div><PrimaryButton class="order-1 mt-[-10px]">Tambah Kelas</PrimaryButton></div> -->
                <div class="order-1"><Modal class="order-1 mt-[-10px]" /></div>
            </div>
        </template>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid sm:grid-cols-4 gap-3 mt-5">
                <div class="rounded bg-cover bg-center" :style="{ 'background-image': 'url('+image+')' }">
                    <div class="py-2 px-5">
                        <p class="font-bold capitalize text-lg text-white">Matematika</p>
                        <p class="text-xs text-white font-light">Selasa, 12.00 WIB</p>
                        <p class="text-xs text-white font-light">Rijal Hafizhun Hidayat</p>
                    </div>
                    <div class="bg-white px-5 pb-32">
                        <p></p>
                    </div>
                </div>
                <div class="rounded bg-cover bg-center" :style="{ 'background-image': 'url('+image+')' }">
                    <div class="py-2 px-5">
                        <p class="font-bold capitalize text-lg text-white">Fisika</p>
                        <p class="text-xs text-white font-light">Rabu, 13.00 WIB</p>
                        <p class="text-xs text-white font-light">Kevin Maulana</p>
                    </div>
                    <div class="bg-white px-5 pb-32">
                        <p></p>
                    </div>
                </div>
                <div class="rounded bg-cover bg-center" :style="{ 'background-image': 'url('+image+')' }">
                    <div class="py-2 px-5">
                        <p class="font-bold capitalize text-lg text-white">Kimia</p>
                        <p class="text-xs text-white font-light">Kamis, 14.00 WIB</p>
                        <p class="text-xs text-white font-light">Purnawan</p>
                    </div>
                    <div class="bg-white px-5 pb-32">
                        <p></p>
                    </div>
                </div>
                <div class="rounded bg-cover bg-center" :style="{ 'background-image': 'url('+image+')' }">
                    <div class="py-2 px-5">
                        <p class="font-bold capitalize text-lg text-white">Indonesia</p>
                        <p class="text-xs text-white font-light">Jumat, 15.00 WIB</p>
                        <p class="text-xs text-white font-light">Fajri Agustian</p>
                    </div>
                    <div class="bg-white px-5 pb-32">
                        <p></p>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
<script>
import { ref } from 'vue'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head } from '@inertiajs/vue3';
import Modal from './Partials/Modal.vue';
export default {
    components: { AuthenticatedLayout, Head, Modal, PrimaryButton },
    setup(){
        const image = ref('')
        image.value = 'images/default/7506073.jpg'

        return {
            image
        }
    }
}
</script>
<style scoped>
/* #bg-image{
    background-size: cover;
    background-position: 0% 80%;
} */
</style>
