<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head, usePage } from '@inertiajs/vue3';
import Table from './Partials/Table.vue';
import { router } from '@inertiajs/vue3'
import { computed } from 'vue'

const page = usePage()
const user = computed(() => page.props.auth.user)

const create = () => {
    router.get('/mahasiswa/create')
}
</script>
<template>
    <Head title="Mahasiswa" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <div><h2 class="font-semibold text-xl text-gray-800 leading-tight">Mahasiswa</h2></div>
                <!-- <div><PrimaryButton class="order-1 mt-[-10px]">Tambah Kelas</PrimaryButton></div> -->
                <div v-if="user.role == 1" class="order-1"><PrimaryButton @click="create">Tambah Mahasiswa</PrimaryButton></div>
            </div>
        </template>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <Table :user="user" />
        </div>
    </AuthenticatedLayout>
</template>