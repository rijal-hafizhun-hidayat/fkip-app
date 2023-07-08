<template>
    <Head title="Mahasiswa" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <div><h2 class="font-semibold text-xl text-gray-800 leading-tight">Guru Pamong</h2></div>
                <!-- <div><PrimaryButton class="order-1 mt-[-10px]">Tambah Kelas</PrimaryButton></div> -->
                <div v-if="user.role === 1" class="order-1"><PrimaryButton @click="create">Tambah Guru Pamong</PrimaryButton></div>
            </div>
        </template>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <Table :user="user"/>
        </div>
    </AuthenticatedLayout>
</template>
<script>
import { computed } from 'vue'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Table from './Partials/Table.vue';
import { Head, router, usePage } from '@inertiajs/vue3';
export default {
    components: { AuthenticatedLayout, Head, PrimaryButton, Table },
    setup(){
        const page = usePage()
        const user = computed(() => page.props.auth.user)

        const create = () => {
            router.get('/guru-pamong/create')
        }

        return {
            page,
            user,
            create
        }
    }
}
</script>
