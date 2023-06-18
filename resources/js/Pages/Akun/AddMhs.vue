<template>
    <Head title="Tambah Mahasiswa" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <div><h2 class="font-semibold text-xl text-gray-800 leading-tight">Tambah Mahasiswa</h2></div>
                <!-- <div><PrimaryButton class="order-1 mt-[-10px]">Tambah Kelas</PrimaryButton></div> -->
                <!-- <div class="order-1"><PrimaryButton>Tambah Akun</PrimaryButton></div> -->
            </div>
        </template>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
        </div>
    </AuthenticatedLayout>
</template>
<script>
import { ref } from 'vue'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3'
export default {
    components: { AuthenticatedLayout, Head, PrimaryButton },
    setup(){
    
    }
}
</script>
