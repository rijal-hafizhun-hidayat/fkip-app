<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import FormUpdateMahasiswa from './Partials/FormUpdateMahasiswa.vue';
import { Head, usePage } from '@inertiajs/vue3';
import { computed } from 'vue'

const page = usePage()
const user = computed(() => page.props.auth.user)
const props = defineProps({
    id: Number,
    prodis: Object
})
</script>
<template>
    <Head title="Ubah Mahasiswa" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <div><h2 class="font-semibold text-xl text-gray-800 leading-tight">Ubah Mahasiswa</h2></div>
            </div>
        </template>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white py-8 px-10 mt-10 rounded-md shadow-md">
                <FormUpdateMahasiswa v-if="user.role == 1" :id="id" :prodis="prodis" />
            </div>
        </div>
    </AuthenticatedLayout>
</template>
