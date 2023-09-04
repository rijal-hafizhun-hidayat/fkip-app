<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DetailMahasiswa from './Partials/DetailMahasiswa.vue';
import { Head } from '@inertiajs/vue3';
import DetailDpl from './Partials/DetailDpl.vue';
import DetailGuruPamong from './Partials/DetailGuruPamong.vue';

const props = defineProps({
    id: Number
})

console.log(props.id)
</script>
<template>
    <Head title="Mahasiswa" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <div><h2 class="font-semibold text-xl text-gray-800 leading-tight">Asosiasi Mahasiswa</h2></div>
            </div>
        </template>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <DetailMahasiswa :id="id"/>
            <DetailDpl :id="id"/>
            <DetailGuruPamong :id="id"/>
        </div>
    </AuthenticatedLayout>
</template>