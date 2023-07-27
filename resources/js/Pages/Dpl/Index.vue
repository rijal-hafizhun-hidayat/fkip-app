<script setup>
import { computed } from 'vue'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head, router, usePage } from '@inertiajs/vue3';
import Table from './Partials/Table.vue';

const page = usePage()
const user = computed(() => page.props.auth.user)

const create = () => {
    router.get('/dpl/create')
}
</script>
<template>
    <Head title="Dpl" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <div><h2 class="font-semibold text-xl text-gray-800 leading-tight">Dpl</h2></div>
                <!-- <div><PrimaryButton class="order-1 mt-[-10px]">Tambah Kelas</PrimaryButton></div> -->
                <div class="order-1"><PrimaryButton @click="create">Tambah Dpl</PrimaryButton></div>
            </div>
        </template>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <Table :user="user"/>
        </div>
    </AuthenticatedLayout>
</template>