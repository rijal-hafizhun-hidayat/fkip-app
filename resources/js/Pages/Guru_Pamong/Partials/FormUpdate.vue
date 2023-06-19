<template>
    <form @submit.prevent="submit" class="mt-6 space-y-6">
        <div>
            <InputLabel for="nama" value="Nama" />
            <TextInput
                id="nama"
                ref="nama"
                type="text"
                class="mt-1 block w-full"
                v-model="form.nama"
                :class="{ 'border-rose-600': validation.nama }"
            />
            <InputError v-if="validation.nama" :message="validation.nama[0]" class="mt-2" />
        </div>
                    
        <div>
            <InputLabel for="asal" value="Asal" />
            <TextInput
                id="asal"
                type="text"
                class="mt-1 block w-full"
                v-model="form.asal"
                :class="{ 'border-rose-600': validation.asal }"
            />
            <InputError v-if="validation.asal" :message="validation.asal[0]" class="mt-2" />
        </div>

        <div>
            <InputLabel for="asal_sekolah" value="Asal Sekolah" />
            <TextInput
                id="asal_sekolah"
                type="text"
                class="mt-1 block w-full"
                v-model="form.asal_sekolah"
                :class="{ 'border-rose-600': validation.asal_sekolah }"
            />
            <InputError v-if="validation.asal_sekolah" :message="validation.asal_sekolah[0]" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <PrimaryButton>Save</PrimaryButton>
        </div>
    </form>
</template>
<script>
import { ref, reactive, onMounted } from 'vue'
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import Dropdown from '@/Components/Dropdown.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { router } from '@inertiajs/vue3';
import Footer from '@/Components/Footer.vue';
import axios from 'axios';
import NProgress from 'nprogress';
import Swal from 'sweetalert2'
export default {
    components: {
        PrimaryButton,
        TextInput,
        InputLabel,
        InputError,
        Dropdown,
        Footer
    },
    props: {
        id: Number
    },
    setup(props){
        const form = reactive({
            nama: '',
            asal: '',
            asal_sekolah: ''
        })

        const validation = ref([])

        onMounted(() =>{
            axios.get(`/getGuruPamongById/${props.id}`)
            .then((res) => {
                form.nama = res.data.data.nama
                form.asal = res.data.data.asal
                form.asal_sekolah = res.data.data.asal_sekolah
            })
            .catch((err) => {
                console.log(err)
            })
        })

        const submit = () => {
            NProgress.start()
            axios.put(`/guru-pamong/${props.id}`, {
                nama: form.nama,
                asal: form.asal,
                asal_sekolah: form.asal_sekolah
            })
            .then((res) => {
                Swal.fire({
                    icon: 'success',
                    title: res.data.title,
                    text: res.data.text
                })
                router.get('/guru-pamong')
            })
            .catch((err) => {
                console.log(err.data.response.errors)
            })
            .finally(() => {
                NProgress.done()
            })
        }

        return {
            form,
            validation,
            submit
        }
    }
}
</script>