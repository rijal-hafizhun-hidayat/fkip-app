<template>
    <div class="bg-white rounded-md shadow overflow-x-auto mt-10">
        <table class="w-full whitespace-nowrap">
            <thead>
                <tr class="text-left font-bold">
                    <th class="pb-4 pt-6 px-6">Nama</th>
                    <th class="pb-4 pt-6 px-6">Username</th>
                    <th class="pb-4 pt-6 px-6">Email</th>
                    <th class="pb-4 pt-6 px-6">Hak Akses</th>
                    <th class="pb-4 pt-6 px-6">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="akun in akuns" :key="akun.id" class="hover:bg-gray-100">
                    <td class="border-t items-center px-6 py-4">
                        {{ akun.nama }}
                    </td>
                    <td class="border-t items-center px-6 py-4">
                        {{ akun.username }}
                    </td>
                    <td class="border-t items-center px-6 py-4">
                        {{ akun.email }}
                    </td>
                    <td v-if="akun.role == 1" class="border-t items-center px-6 py-4">
                        Admin
                    </td>
                    <td v-else-if="akun.role == 2" class="border-t items-center px-6 py-4">
                        DPL
                    </td>
                    <td v-else class="border-t items-center px-6 py-4">
                        Guru Pamong
                    </td>
                    <td class="border-t items-center px-6 py-4">
                    <div class="flex flex-row space-x-4">
                        <DestroyButton @click="destroy(akun.id)"><i class="fa-solid fa-trash text-white"></i></DestroyButton>
                        <UpdateButton @click="update(akun.id)"><i class="fa-solid fa-pen-to-square text-white"></i></UpdateButton>
                        <MahasiswaButton @click="addMhs(akun.id)"><i class="fa-solid fa-user-plus text-white"></i></MahasiswaButton>
                    </div>
                    
                    </td>
                </tr>
            <!-- <tr v-if="organizations.data.length === 0">
                <td class="px-6 py-4 border-t" colspan="4">No organizations found.</td>
            </tr> -->
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
import MahasiswaButton from '@/Components/MahasiswaButton.vue';
import { router } from '@inertiajs/vue3'
import Swal from 'sweetalert2'
export default{
    components: { DestroyButton, UpdateButton, MahasiswaButton },
    setup(){
        const akuns = ref([])
        onMounted(() => {
            NProgress.start()
            axios.get('/getAkuns')
            .then((res) => {
                akuns.value = res.data.data
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
            axios.delete(`/akuns/${id}`)
            .then((res) => {
                Swal.fire({
                    icon: 'success',
                    title: res.data.title,
                    text: res.data.text
                })

                router.get('/akuns')
            })
            .catch((err) => {
                console.log(err)
            })
            .finally(() => {
                NProgress.done()
            })
        }

        const update = (id) => {
            router.get(`/akun/${id}`)
        }

        const addMhs = (id) => {
            router.get(`/akun/tambah-mahasiswa/${id}`)
        }

        return {
            akuns,
            destroy,
            update,
            addMhs
        }
    }
}
</script>