<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DetailMahasiswa from './Partials/DetailMahasiswa.vue'
import { Head, usePage } from '@inertiajs/vue3';
import Table from './Partials/Table.vue';
import ModalCreateBimbingan from './Partials/ModalCreateBimbingan.vue'
import { computed } from 'vue'
import { router } from '@inertiajs/vue3'

const page = usePage()
const user = computed(() => page.props.auth.user)
const props = defineProps({
    id: Number
})

const printPdf = (id) => {
    //router.get(`/bimbingan/print/${id}`)
    window.open(`/bimbingan/print/${id}`, '_blank');
}

</script>
<template>
    <Head title="Dpl" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <div><h2 class="font-semibold text-xl text-gray-800 leading-tight">Bimbingan Mahasiswa</h2></div>
                <div class="flex justify-end space-x-4">
                    <div v-if="user.role == 4 || user.role == 2"><ModalCreateBimbingan :id="id"/></div>
                    <div v-if="user.role == 4 || user.role == 2"><PrimaryButton @click="printPdf(id)">Cetak Bimbingan</PrimaryButton></div>
                </div>
            </div>
        </template>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <DetailMahasiswa :id="id"/>
            <Table :id="id" :user="user"/>
        </div>
    </AuthenticatedLayout>
</template>
