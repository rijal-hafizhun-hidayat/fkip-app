<script setup>
    import { computed } from 'vue';
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import FormAddMahasiswa from './Partials/FormAddMahasiswa.vue';
    import TableMahasiswa from './Partials/TableMahasiswa.vue';
    import DetailGuruPamong from './Partials/DetailGuruPamong.vue';
    import { Head, usePage } from '@inertiajs/vue3';

    const props = defineProps({
        id: Number
    })

    const page = usePage()
    const user = computed(() => page.props.auth.user)
</script>

<template>
    <Head title="Tambah Asosiasi Mahasiswa" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <div><h2 class="font-semibold text-xl text-gray-800 leading-tight"><span v-if="user.role == 1">Tambah</span> Guru Pamong Asosiasi Mahasiswa</h2></div>
            </div>
        </template>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-7">
            <div class="bg-white py-8 px-10 mt-10 rounded-md shadow-md">
                <FormAddMahasiswa v-if="user.role == 1" :id="props.id"/>
                <DetailGuruPamong v-if="user.role == 2" :id="props.id"/>
            </div>
            <TableMahasiswa :id="props.id"/>
        </div>
    </AuthenticatedLayout>
</template>