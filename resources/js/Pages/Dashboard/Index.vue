<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import WelcomeMessage from './Partials/WelcomeMessage.vue'
import WarningMessage from './Partials/WarningMessage.vue';
import TableGuruPamong from './Partials/TableGuruPamong.vue';
import TableDpl from './Partials/TableDpl.vue';
import { Head, usePage } from '@inertiajs/vue3';
import { computed } from 'vue'

const page = usePage()
const user = computed(() => page.props.auth.user)

</script>
<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <div><h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2></div>
            </div>
        </template>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <WelcomeMessage :nama="user.nama"/>
            <WarningMessage />
            <TableGuruPamong v-if="user.role == 4" :id_mahasiswa="user.id_mahasiswa"/>
            <TableDpl v-if="user.role == 4" :id_mahasiswa="user.id_mahasiswa"/>
        </div>
    </AuthenticatedLayout>
</template>
