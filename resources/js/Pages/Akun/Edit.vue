<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import FormUpdate from './partials/FormUpdate.vue';
import TableDpl from './partials/TableDpl.vue';
import TableGuruPamong from './partials/TableGuruPamong.vue';

defineProps({
    id: Number,
    prodis: Object,
    guruPamongs: Object,
    dpls: Object,
    roleAkun: Number
})
</script>
<template>
    <Head title="Edit Akun" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <div><h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Akun</h2></div>
            </div>
        </template>

        <div class="max-w-7xl mx-auto px-4 pb-10 sm:px-6 lg:px-8">
            <div class="bg-white py-8 px-10 mt-10 rounded-md shadow-md">
                <FormUpdate :id="id" :prodis="prodis" :guruPamongs="guruPamongs" :dpls="dpls"/>
            </div>
            <TableDpl v-if="roleAkun == 2" :id="id"/>
            <TableGuruPamong v-if="roleAkun == 3" :id="id"/>
        </div>
    </AuthenticatedLayout>
</template>