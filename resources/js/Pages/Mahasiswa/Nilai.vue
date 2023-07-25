<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';
import FormNilaiNb from './Partials/FormNilaiNb.vue';
import FormNilaiNc from './Partials/FormNilaiNc.vue';
import FormNilaiNd from './Partials/FormNilaiNd.vue';
import FormNilaiNe from './Partials/FormNilaiNe.vue';
import TableNilai from './Partials/TableNilai.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { computed, ref } from 'vue'

const isClickNb = ref(false)
const isClickNc = ref(false)
const isClickNd = ref(false)
const isClickNe = ref(false)
const valueJenisPertanyaan = ref('')
const page = usePage()
const user = computed(() => page.props.auth.user)
const props = defineProps({
    jenis_plp: String,
    jenis_bidang: String,
    id: Number
})

const setIsClick = (isClick) => {
    if(isClick == 'nb'){
        isClickNb.value = true
        isClickNc.value = false
        isClickNd.value = false
        isClickNe.value = false
    }
    else if(isClick == 'nc'){
        isClickNb.value = false
        isClickNc.value = true
        isClickNd.value = false
        isClickNe.value = false
    }
    else if(isClick == 'nd'){
        isClickNb.value = false
        isClickNc.value = false
        isClickNd.value = true
        isClickNe.value = false
    }
    else{
        isClickNb.value = false
        isClickNc.value = false
        isClickNd.value = false
        isClickNe.value = true
    }

    return true
}

//console.log(props.jenis_plp, props.jenis_bidang, props.id)

</script>
<template>
    <Head title="Tambah Nilai Mahasiswa" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <div><h2 class="font-semibold text-xl text-gray-800 leading-tight">Nilai Mahasiswa</h2></div>
            </div>
        </template>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div v-if="user.role === 3" class="flex mt-8 space-x-4">
                <div><PrimaryButton @click="setIsClick('nb')">+ Nilai Nb</PrimaryButton></div>
                <div><PrimaryButton v-if="jenis_plp == 'plp_2' && jenis_bidang == 'teaching'" @click="setIsClick('nc')">+ Nilai Nc</PrimaryButton></div>
                <div><PrimaryButton v-if="jenis_plp == 'plp_2' && jenis_bidang == 'bk'" @click="setIsClick('nc')">+ Nilai Nc</PrimaryButton></div>
                <div><PrimaryButton v-if="jenis_plp == 'plp_2' && jenis_bidang == 'pgpaud'" @click="setIsClick('nd')">+ Nilai Nd</PrimaryButton></div>
                <div><PrimaryButton v-if="jenis_plp == 'plp_2' && jenis_bidang == 'bk'" @click="setIsClick('nd')">+ Nilai Nd</PrimaryButton></div>
                <div><PrimaryButton v-if="jenis_plp == 'plp_2' && jenis_bidang == 'bk'" @click="setIsClick('ne')">+ Nilai Ne</PrimaryButton></div>
            </div>

            <TableNilai :id="id" :prodi="prodi" :jenis_plp="jenis_plp" :jenis_bidang="jenis_bidang"/>

            <div v-if="user.role === 3">
                <div v-if="isClickNb == true" class="bg-white py-8 px-10 mt-10 rounded-md shadow-md">
                    <FormNilaiNb :jenis_plp="jenis_plp" :jenis_bidang="jenis_bidang" :jenis_pertanyaan="'nb'" :id="id"/>
                </div>
                <div v-if="isClickNc == true" class="bg-white py-8 px-10 mt-10 rounded-md shadow-md">
                    <FormNilaiNc :jenis_plp="jenis_plp" :jenis_bidang="jenis_bidang" :jenis_pertanyaan="'nc'" :id="id"/>
                </div>
                <div v-if="isClickNd == true" class="bg-white py-8 px-10 mt-10 rounded-md shadow-md">
                    <FormNilaiNd :jenis_plp="jenis_plp" :jenis_bidang="jenis_bidang" :jenis_pertanyaan="'nd'" :id="id"/>
                </div>
                <div v-if="isClickNe == true" class="bg-white py-8 px-10 mt-10 rounded-md shadow-md">
                    <FormNilaiNe :jenis_plp="jenis_plp" :jenis_bidang="jenis_bidang" :jenis_pertanyaan="'ne'" :id="id"/>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>