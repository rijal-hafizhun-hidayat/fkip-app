<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';
import FormCreateAsosiasiDpl from './Partials/FormCreateAsosiasiDpl.vue'
import TableAsosiasiDpl from './Partials/TableAsosiasiDpl.vue';
import axios from 'axios';
import { ref, onMounted, computed} from 'vue'

const page = usePage()
const user = computed(() => page.props.auth.user)
const idDpl = ref('')
const props = defineProps({
    id: Number,
    dpls: Object
})
</script>
<template>
    <Head title="Asosiasi Mahasiswa DPL" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <div><h2 class="font-semibold text-xl text-gray-800 leading-tight">Asosiasi Mahasiswa DPL</h2></div>
            </div>
        </template>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <FormCreateAsosiasiDpl :id="id" :dpls="dpls"/>
            <TableAsosiasiDpl :user="user" :id="id"/>
        </div>
    </AuthenticatedLayout>
</template>