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
                <FormNilai :id="id"/>
            </div>
            <TableNilai :id="id"/>
        </div>
    </AuthenticatedLayout>
</template>
<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import FormNilai from './Partials/FormNilai.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TableNilai from './Partials/TableNilai.vue';
export default {
    components: {
        AuthenticatedLayout,
        Head,
        FormNilai,
        PrimaryButton,
        TableNilai
    },
    props: {
        id: Number
    }
}
</script>
