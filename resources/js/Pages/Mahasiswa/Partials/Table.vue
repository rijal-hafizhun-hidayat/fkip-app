<template>
    <div class="bg-white rounded-md shadow overflow-x-auto mt-10">
        <table class="w-full whitespace-nowrap">
            <thead>
                <tr class="text-left font-bold">
                    <th class="pb-4 pt-6 px-6">Nim</th>
                    <th class="pb-4 pt-6 px-6">Nama</th>
                    <th class="pb-4 pt-6 px-6">Prodi</th>
                    <th class="pb-4 pt-6 px-6">Email</th>
                    <th class="pb-4 pt-6 px-6">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="mahasiswa in mahasiswas" :key="mahasiswa.id" class="hover:bg-gray-100">
                    <td class="border-t items-center px-6 py-4">
                        {{ mahasiswa.nim }}
                    </td>
                    <td class="border-t items-center px-6 py-4">
                        {{ mahasiswa.nama }}
                    </td>
                    <td class="border-t items-center px-6 py-4">
                        {{ mahasiswa.prodi }}
                    </td>
                    <td class="border-t items-center px-6 py-4">
                        {{ mahasiswa.email }}
                    </td>
                    <td class="border-t">
                        <div class="flex flex-row space-x-4">
                            <DestroyButton @click="destroy(mahasiswa.id)"><i class="fa-solid fa-trash text-white"></i></DestroyButton>
                            <UpdateButton @click="show(mahasiswa.id)"><i class="fa-solid fa-pen-to-square text-white"></i></UpdateButton>
                            <MahasiswaButton><i class="fa-solid fa-user-plus text-white"></i></MahasiswaButton>
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
        const mahasiswas = ref([])

        onMounted(() => {
            NProgress.start()
            axios.get('/getMahasiswa')
            .then((res) => {
                mahasiswas.value = res.data.data
            })
            .catch((err) => {
                console.log(err)
            })
            .finally(() => {
                NProgress.done()
            })
        })

        const show = (id) => {
            router.get(`/mahasiswa/${id}`)
        }

        const destroy = (id) => {
            NProgress.start()
            axios.delete(`/mahasiswa/${id}`)
            .then((res) => {
                Swal.fire({
                    icon: 'success',
                    title: res.data.title,
                    text: res.data.text
                })
                router.get('/mahasiswa')
            })
            .catch((err) => {
                console.log(err)
            })
            .finally(() => {
                NProgress.done()
            })
        }

        return {
            mahasiswas,
            show,
            destroy
        }
    }
}
</script>