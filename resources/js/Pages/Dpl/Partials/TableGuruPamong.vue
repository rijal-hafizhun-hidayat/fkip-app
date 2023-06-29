<template>
    <div class="bg-white rounded-md shadow-md overflow-x-auto mt-10">
        <table class="w-full whitespace-nowrap">
            <thead>
                <tr class="text-left font-bold">
                    <th class="pb-4 pt-6 px-6">Nama</th>
                    <th class="pb-4 pt-6 px-6">Asal</th>
                    <th class="pb-4 pt-6 px-6">Sekolah</th>
                    <th class="pb-4 pt-6 px-6">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="dplGuruPamong in dplGuruPamongById" :key="dplGuruPamong.id" class="hover:bg-gray-100">
                    <td class="border-t items-center px-6 py-4">
                        {{ dplGuruPamong.nama }}
                    </td>
                    <td class="border-t items-center px-6 py-4">
                        {{ dplGuruPamong.asal }}
                    </td>
                    <td class="border-t items-center px-6 py-4">
                        {{ dplGuruPamong.asal_sekolah }}
                    </td>
                    <td class="border-t items-center px-6 py-4">
                        <div class="flex flex-row space-x-4">
                            <DestroyButton @click="destroy(dplGuruPamong.id)"><i class="fa-solid fa-trash text-white"></i></DestroyButton>
                        </div>
                    </td>
                </tr>
            <tr v-if="dplGuruPamongById.length === 0">
                <td class="px-6 py-4 text-center border-t" colspan="4">No data found.</td>
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
    props: {
        id: Number
    },
    setup(props){
        const dplGuruPamongById = ref([])

        onMounted(() => {
            axios.get(`/getDplGuruPamongById/${props.id}`)
            .then((res) => {
                dplGuruPamongById.value = res.data.data
            })
            .catch((err) => {
                console.log(err)
            })
        })

        const destroy = (id) => {
            //console.log(id)
            axios.put(`/destroyAssociationGuruPamong/${id}`)
            .then((res) => {
                Swal.fire({
                    icon: 'success',
                    title: res.data.title,
                    text: res.data.text
                })
                router.get(`/dpl/guru-pamong/${props.id}`)
            })
            .catch((err) => {
                console.log(err)
            })
        }

        return {
            dplGuruPamongById,
            destroy
        }
    }
}
</script>