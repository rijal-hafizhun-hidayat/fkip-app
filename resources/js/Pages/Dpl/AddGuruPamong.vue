<template>
    <Head title="Tambah Asosiasi Guru Pamong" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <div><h2 class="font-semibold text-xl text-gray-800 leading-tight">Tambah Asosiasi DPL Guru Pamong</h2></div>
            </div>
        </template>

        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white py-8 px-10 mt-10 rounded-md shadow-md">
                <FormAddGuruPamong :id="id"/>
            </div>
            <TableGuruPamong :id="id"/>
        </div>
    </AuthenticatedLayout>
</template>
<script>
import { ref } from 'vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import FormAddGuruPamong from './Partials/FormAddGuruPamong.vue';
import TableGuruPamong from './Partials/TableGuruPamong.vue';
export default {
    components: {
        AuthenticatedLayout,
        Head,
        PrimaryButton,
        FormAddGuruPamong,
        TableGuruPamong
    },
    props: {
        id: Number
    }
}
</script>
