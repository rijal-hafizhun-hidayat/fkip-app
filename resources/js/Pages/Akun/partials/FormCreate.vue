<template>
    <form @submit.prevent="submit" class="mt-6 space-y-6">
        <div>
            <InputLabel for="nama" value="Nama" />
            <TextInput
                id="nama_depan"
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
            <SelectInput class="mt-1 blobk w-full" v-model="form.prodi" @change="setUsername(form.nama, form.prodi)" :class="{ 'border-rose-600': validation.prodi }">
                <option selected disabled value="">-- Pilih --</option>
                <option v-for="prodi in prodis">{{ prodi.nama }}</option>
            </SelectInput>
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
            <InputLabel for="password" value="Password" />
            <TextInput
                id="password"
                type="password"
                class="mt-1 block w-full"
                v-model="form.password"
                :class="{ 'border-rose-600': validation.password }"
            />
            <InputError v-if="validation.password" :message="validation.password[0]" class="mt-2" />
        </div>

        <div>
            <InputLabel for="role" value="Role"/>
            <SelectInput class="mt-1 blobk w-full" v-model="form.role" :class="{ 'border-rose-600': validation.role }">
                <option selected disabled value="">-- Pilih --</option>
                <option value="1">Admin</option>
                <option value="2">DPL</option>
                <option value="3">Guru Pamong</option>
            </SelectInput>
            <InputError v-if="validation.role" :message="validation.role[0]" class="mt-2" />
        </div>

        <div v-if="form.role == 3">
            <InputLabel for="id_guru_pamong" value="Guru Pamong"/>
            <Multiselect v-model="form.id_guru_pamong" :custom-label="nameWithLang" :options="guruPamongs"></Multiselect>
            <InputError v-if="validation.id_guru_pamong" :message="validation.id_guru_pamong[0]" class="mt-2" />
        </div>

        <div v-if="form.role == 2">
            <InputLabel for="id_dpl" value="Dpl"/>
            <Multiselect v-model="form.id_dpl" :custom-label="nameWithLang" :options="dpls"></Multiselect>
            <InputError v-if="validation.id_dpl" :message="validation.id_dpl[0]" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <PrimaryButton>Save</PrimaryButton>
        </div>
    </form>
</template>
<script>
import { ref, reactive } from 'vue'
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import Dropdown from '@/Components/Dropdown.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SelectInput from '@/Components/SelectInput.vue';
import { router } from '@inertiajs/vue3';
import Footer from '@/Components/Footer.vue';
import axios from 'axios';
import NProgress from 'nprogress';
import Swal from 'sweetalert2'
import Multiselect from 'vue-multiselect'
import 'vue-multiselect/dist/vue-multiselect.css'
export default {
    components: {
        PrimaryButton,
        TextInput,
        InputLabel,
        InputError,
        Dropdown,
        SelectInput,
        Footer,
        Multiselect
    },
    props: {
        guruPamongs: Object,
        prodis: Object,
        dpls: Object
    },
    setup(props){
        const form = reactive({
            nama: '',
            username: '',
            email: '',
            password: '',
            role: '',
            prodi: '',
            id_guru_pamong: '',
            id_dpl: ''
        })
        const disabled = ref(true)
        const validation = ref([])
        const submit = () => {
            NProgress.start()
            axios.post('/akun', {
                nama: form.nama,
                username: form.username,
                email: form.email,
                password: form.password,
                role: form.role,
                prodi: form.prodi,
                id_guru_pamong: form.id_guru_pamong.id,
                id_dpl: form.id_dpl.id
            })
            .then((res) => {
                Swal.fire({
                    icon: 'success',
                    title: res.data.title,
                    text: res.data.text
                })

                router.get('/akun')
            })
            .catch((err) => {
                validation.value = err.response.data.errors
            })
            .finally(() => {
                NProgress.done()
            })
        }

        const setUsername = (nama, prodi) => {
            let firstWord = nama.split(" ")[0]
            form.username = firstWord+'_'+prodi
        }

        const nameWithLang = ({nama}) => {
            return nama
        }

        return {
            form,
            validation,
            disabled,
            submit,
            setUsername,
            nameWithLang
        }
    }
}
</script>
<!-- <style src="vue-multiselect/dist/vue-multiselect.min.css"></style> -->