<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
</script>
<template>
    <div class="bg-white rounded-md shadow overflow-x-auto mt-3">
        <table class="w-full whitespace-nowrap">
            <thead>
                <tr class="text-left font-bold">
                    <th class="pb-4 pt-6 px-6">Waktu Bimbingan</th>
                    <th class="pb-4 pt-6 px-6">Keterangan Bimbingan</th>
                    <th class="pb-4 pt-6 px-6">Catatan Pembimbing</th>
                    <th class="pb-4 pt-6 px-6">Action</th>
                </tr>
            </thead>
            <tbody>
                    <!-- <tr v-for="guruPamong in guruPamongs.data" :key="guruPamong.id" class="hover:bg-gray-100">
                        <td class="border-t items-center px-6 py-4">
                            {{ guruPamong.nama }}
                        </td>
                        <td class="border-t items-center px-6 py-4">
                            {{ guruPamong.asal }}
                        </td>
                        <td class="border-t items-center px-6 py-4">
                            {{ guruPamong.asal_sekolah }}
                        </td>
                        <td class="border-t items-center px-6 py-4">
                            {{ guruPamong.bidang_keahlian }}
                        </td>
                        <td class="border-t items-center px-6 py-4">
                            <div class="flex flex-row space-x-4">
                                <DestroyButton v-if="user.role === 1" @click="destroy(guruPamong.id)"><i class="fa-solid fa-trash text-white"></i></DestroyButton>
                                <UpdateButton v-if="user.role === 1" @click="show(guruPamong.id)"><i class="fa-solid fa-pen-to-square text-white"></i></UpdateButton>
                                <DetailButton v-if="user.role === 1 || user.role === 2" @click="addAsosiasiMahasiswa(guruPamong.id)"><i :class="user.role === 1 ? 'fa-solid fa-person-circle-plus fa-xl' : 'fa-solid fa-people-arrows fa-xl'"></i></DetailButton>
                            </div>
                        </td>
                    </tr>
                    <tr v-if="length === 0">
                        <td class="px-6 py-4 text-center border-t" colspan="5">No data found.</td>
                    </tr> -->
            </tbody>
        </table>
    </div>
</template>