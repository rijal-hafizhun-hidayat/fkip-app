<template>
    <form @submit.prevent="submit" class="space-y-6">
        <div class="flex">
            <InputLabel for="nipy" class="basis-1/4 mt-3" value="Nip / Niy" />
            <TextInput
                disabled
                id="nipy"
                type="text"
                class="mt-1 block w-full bg-slate-200"
                v-model="form.nipy"
            />
        </div>
        <div class="flex">
            <InputLabel for="ama" class="basis-1/4 mt-3" value="Nama" />
            <TextInput
                disabled
                id="nipy"
                type="text"
                class="mt-1 block w-full bg-slate-200"
                v-model="form.nama"
            />
        </div>
        <div class="flex">
            <InputLabel for="email" class="basis-1/4 mt-3" value="Email" />
            <TextInput
                disabled
                id="nipy"
                type="text"
                class="mt-1 block w-full bg-slate-200"
                v-model="form.email"
            />
        </div>
        <div class="flex">
            <InputLabel for="prodi" class="basis-1/4 mt-3" value="Prodi" />
            <TextInput
                disabled
                id="nipy"
                type="text"
                class="mt-1 block w-full bg-slate-200"
                v-model="form.prodi"
            />
        </div>
        <div class="flex">
            <InputLabel class="basis-1/4 mt-3" for="id_dpl" value="Guru Pamong"/>
            <Multiselect v-model="form.id_guru_pamong" :custom-label="nameWithLang" :options="guruPamongs"></Multiselect>
            <!-- <InputError v-if="validation.id_guru_pamong" :message="validation.id_guru_pamong[0]" class="mt-2" /> -->
        </div>
        <PrimaryButton>Submit</PrimaryButton>
    </form>
</template>
<script>
import { ref, reactive, onMounted } from 'vue'
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import axios from 'axios';
import { router } from '@inertiajs/vue3';
import Multiselect from 'vue-multiselect'
import 'vue-multiselect/dist/vue-multiselect.css'
import Swal from 'sweetalert2';
export default {
    components: {
        PrimaryButton,
        TextInput,
        InputLabel,
        InputError,
        Multiselect
    },
    props: {
        id: Number
    },
    setup(props){
        onMounted(() => {
            getDplById(props.id)
            getGuruPamongs()
        })
        const form = reactive({
            nama: '',
            nipy: '',
            email: '',
            prodi: '',
            id_guru_pamong: ''
        })

        const validation = ref([])
        const guruPamongs = ref([])

        const submit = () => {
            axios.put(`/storeGuruPamong/${props.id}`, {
                id_guru_pamong: form.id_guru_pamong.id
            })
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

        const getDplById = (id) => {
            axios.get(`/getDplById/${id}`)
            .then((res) => {
                form.nama = res.data.data.nama
                form.nipy = res.data.data.nipy
                form.email = res.data.data.email
                form.prodi = res.data.data.prodi
            })
            .catch((err) => {
                console.log(err)
            })
        }

        const getGuruPamongs = () => {
            axios.get('/getGuruPamongsIsNull')
            .then((res) => {
                guruPamongs.value = res.data.data
            })
            .catch((err) => {
                console.log(err)
            })
        }

        const nameWithLang = ({nama}) => {
            return nama
        }

        return {
            validation,
            form,
            guruPamongs,
            getDplById,
            getGuruPamongs,
            nameWithLang,
            submit
        }
    }
}
</script>