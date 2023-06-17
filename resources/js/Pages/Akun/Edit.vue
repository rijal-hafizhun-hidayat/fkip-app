<template>
    <Head title="Edit Akun" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <div><h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Akun</h2></div>
            </div>
        </template>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white py-8 px-10 mt-10 rounded-md shadow-md">
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
                            @change="setUsername(form.nama, form.prodi)"
                        />
                        <InputError v-if="validation.nama" :message="validation.nama[0]" class="mt-2" />
                    </div>

                    <div>
                        <InputLabel for="prodi" value="Prodi"/>
                        <Select class="mt-1 blobk w-full" v-model="form.prodi" @change="setUsername(form.nama, form.prodi)" :class="{ 'border-rose-600': validation.prodi }">
                            <option selected disabled value="">-- Pilih --</option>
                            <option v-for="prodi in prodis">{{ prodi.nama }}</option>
                        </Select>
                        <InputError v-if="validation.prodi" :message="validation.prodi[0]" class="mt-2" />
                    </div>

                    <div>
                        <InputLabel for="username" value="Username" />
                        <TextInput
                            :disabled="disabled"
                            id="username"
                            ref="username"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.username"
                            :class="{ 'border-rose-600': validation.username, 'bg-slate-200': disabled }"
                        />
                        <InputError v-if="validation.username" :message="validation.username[0]" class="mt-2" />
                    </div>

                    <div>
                        <InputLabel for="email" value="Email" />
                        <TextInput
                            id="email"
                            type="email"
                            class="mt-1 block w-full"
                            v-model="form.email"
                            :class="{ 'border-rose-600': validation.email }"
                        />
                        <InputError v-if="validation.email" :message="validation.email[0]" class="mt-2" />
                    </div>

                    <div>
                        <InputLabel for="role" value="Role"/>
                        <Select class="mt-1 blobk w-full" v-model="form.role" :class="{ 'border-rose-600': validation.role }">
                            <option selected disabled value="">-- Pilih --</option>
                            <option value="1">Admin</option>
                            <option value="2">DPL</option>
                            <option value="3">Guru Pamong</option>
                        </Select>
                        <InputError v-if="validation.role" :message="validation.role[0]" class="mt-2" />
                    </div>

                    <div class="flex items-center gap-4">
                        <PrimaryButton >Save</PrimaryButton>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
<script>
import { ref, reactive, onMounted } from 'vue'
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Dropdown from '@/Components/Dropdown.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Select from '@/Components/Select.vue'
import { Head, router } from '@inertiajs/vue3';
import Footer from '@/Components/Footer.vue';
import axios from 'axios';
import NProgress from 'nprogress';
import Swal from 'sweetalert2'
export default {
    components: {
        AuthenticatedLayout,
        Head,
        PrimaryButton,
        TextInput,
        InputLabel,
        InputError,
        Dropdown,
        Select,
        Footer
    },
    props: {
        id: Number,
        prodis: Object
    },
    setup(props){
        const form = reactive({
            nama: '',
            username: '',
            email: '',
            role: '',
            prodi: ''
        })

        const disabled = ref(true)

        const validation = ref([])

        onMounted(() => {
            NProgress.start()
            axios.get(`/getAkunById/${props.id}`)
            .then((res) => {
                form.nama = res.data.data.nama
                form.username = res.data.data.username
                form.email = res.data.data.email
                form.role = res.data.data.role
                form.prodi = res.data.data.prodi
            })
            .catch((err) => {
                console.log(err)
            })
            .finally(() => {
                NProgress.done()
            })
        })

        const submit = () => {
            NProgress.start()
            axios.put(`/akun/${props.id}`, {
                nama: form.nama,
                username: form.username,
                email: form.email,
                role: form.role,
                prodi: form.prodi
            })
            .then((res) => {
                Swal.fire({
                    icon: 'success',
                    title: res.data.title,
                    text: res.data.text
                })
                
                router.get('/akuns')
            })
            .catch((err) => {
                validation.value = err.response.data.errors
            })
            .finally(() => {
                NProgress.done()
            })
        }

        const setUsername = (nama, prodi) => {
            form.username = nama+'_'+prodi
        }

        return {
            form,
            validation,
            disabled,
            submit,
            setUsername
        }
    }
}
</script>
