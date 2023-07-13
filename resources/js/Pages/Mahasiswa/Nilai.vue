<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';
import FormNilai from './Partials/FormNilai.vue';
import TableNilai from './Partials/TableNilai.vue';
import DetailMahasiswa from './Partials/DetailMahasiswa.vue';
import { computed } from 'vue'

defineProps({
    id: Number
})

const page = usePage()
const user = computed(() => page.props.auth.user)
</script>
<template>
    <Head title="Tambah Nilai Mahasiswa" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <div><h2 class="font-semibold text-xl text-gray-800 leading-tight">Nilai Mahasiswa</h2></div>
            </div>
        </template>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white py-8 px-10 mt-10 rounded-md shadow-md">
                <DetailMahasiswa v-if="user.role === 2 || user.role === 1" :id="id"/>
                <FormNilai class="mt-10" v-if="user.role === 3 || user.role === 1" :id="id"/>
            </div>
            <TableNilai :id="id"/>
        </div>
    </AuthenticatedLayout>
</template>