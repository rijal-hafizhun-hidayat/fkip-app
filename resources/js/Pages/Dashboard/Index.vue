<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <div><h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2></div>
                <!-- <div><PrimaryButton class="order-1 mt-[-10px]">Tambah Kelas</PrimaryButton></div> -->
            </div>
        </template>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white mt-10 px-4 py-6 rounded shadow-md">
                <p>Selamat Datang {{ $page.props.auth.user.nama }}</p>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
<script>
import { ref, computed } from 'vue'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head, usePage } from '@inertiajs/vue3';
export default {
    components: { AuthenticatedLayout, Head, PrimaryButton },
    setup(){
        
    }
}
</script>
<style scoped>
/* #bg-image{
    background-size: cover;
    background-position: 0% 80%;
} */
</style>
