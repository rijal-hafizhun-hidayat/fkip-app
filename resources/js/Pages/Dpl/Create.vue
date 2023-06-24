<template>
    <Head title="Tambah Dpl" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <div><h2 class="font-semibold text-xl text-gray-800 leading-tight">Tambah Dpl</h2></div>
            </div>
        </template>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white py-8 px-10 mt-10 rounded-md shadow-md">
                <div class="space-x-4">
                    <PrimaryButton @click="clickForm(false)">Manual</PrimaryButton>
                    <PrimaryButton @click="clickForm(true)">Import</PrimaryButton>
                </div>
                <FormCreate v-if="!isClick" :prodis="prodis"/>
                <FormImport v-if="isClick"/>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
<script>
import { ref } from 'vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import FormCreate from './Partials/FormCreate.vue';
import FormImport from './Partials/FormImport.vue';
export default {
    components: {
        AuthenticatedLayout,
        Head,
        FormCreate,
        FormImport,
        PrimaryButton
    },
    props: {
        guruPamongs: Object,
        prodis: Object
    },
    setup(){
        const isClick= ref(false);

        const clickForm = (isBool) => {
            isClick.value = isBool
        }

        return {
            isClick,
            clickForm
        }
    }
}
</script>
