<template>
    <Head title="Tambah Asosiasi Mahasiswa" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <div><h2 class="font-semibold text-xl text-gray-800 leading-tight">Tambah Asosiasi Mahasiswa</h2></div>
            </div>
        </template>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-7">
            <div class="bg-white py-8 px-10 mt-10 rounded-md shadow-md">
                <FormAddMahasiswa :id="id"/>
            </div>
            <TableMahasiswa :id="id"/>
        </div>
    </AuthenticatedLayout>
</template>
<script>
import { ref } from 'vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import FormAddMahasiswa from './Partials/FormAddMahasiswa.vue';
import TableMahasiswa from './Partials/TableMahasiswa.vue';
import { Head } from '@inertiajs/vue3';
export default {
    components: {
        AuthenticatedLayout,
        Head,
        PrimaryButton,
        FormAddMahasiswa,
        TableMahasiswa
    },
    props: {
        id: Number
    }
}
</script>
