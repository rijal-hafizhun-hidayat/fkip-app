<template>
    <div class="bg-white rounded-md shadow overflow-x-auto mt-10">
        <table class="w-full whitespace-nowrap">
            <thead>
                <tr class="text-left font-bold">
                    <th class="pb-4 pt-6 px-6">Nip / Niy</th>
                    <th class="pb-4 pt-6 px-6">Nama</th>
                    <th class="pb-4 pt-6 px-6">Prodi</th>
                    <th class="pb-4 pt-6 px-6">Email</th>
                    <th class="pb-4 pt-6 px-6">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="dpl in dpls" :key="dpl.id" class="hover:bg-gray-100">
                    <td class="border-t items-center px-6 py-4">
                        {{ dpl.nipy }}
                    </td>
                    <td class="border-t items-center px-6 py-4">
                        {{ dpl.nama }}
                    </td>
                    <td class="border-t items-center px-6 py-4">
                        {{ dpl.prodi }}
                    </td>
                    <td class="border-t items-center px-6 py-4">
                        {{ dpl.email }}
                    </td>
                    <td class="border-t items-center px-6 py-4">
                        <div class="flex flex-row space-x-4">
                            <DestroyButton @click="destroy(dpl.id)"><i class="fa-solid fa-trash text-white"></i></DestroyButton>
                            <UpdateButton @click="update(dpl.id)"><i class="fa-solid fa-pen-to-square text-white"></i></UpdateButton>
                        </div>
                    </td>
                </tr>
            <tr v-if="dpls.length === 0">
                <td class="px-6 py-4 text-center border-t" colspan="5">No data found.</td>
            </tr>
            </tbody>
        </table>
    </div>
</template>
<script>
import { onMounted, ref } from 'vue';
import axios from 'axios';
import NProgress from 'nprogress';
import DestroyButton from '@/Components/DestroyButton.vue';
import UpdateButton from '@/Components/UpdateButton.vue';
import { router } from '@inertiajs/vue3'
import Swal from 'sweetalert2'
export default{
    components: { DestroyButton, UpdateButton },
    setup(){
        const dpls = ref([])
        onMounted(() => {
            NProgress.start()
            axios.get('getDpls')
            .then((res) => {
                dpls.value = res.data.data
            })
            .catch((err) => {
                console.log(err)
            })
            .finally(() => {
                NProgress.done()
            })
        })

        const destroy = (id) => {
            NProgress.start()
            axios.delete(`/dpl/${id}`)
            .then((res) => {
                Swal.fire({
                    icon: 'success',
                    title: res.data.title,
                    text: res.data.text
                })

                router.get('/dpl')
            })
            .catch((err) => {
                console.log(err)
            })
            .finally(() => {
                NProgress.done()
            })
        }

        const update = (id) => {
            router.get(`/dpl/${id}`)
        }

        return {
            dpls,
            destroy,
            update
        }
    }
}
</script>