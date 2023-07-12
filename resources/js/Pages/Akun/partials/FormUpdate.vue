<script setup>
import { ref, reactive, onMounted } from 'vue'
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SelectInput from '@/Components/SelectInput.vue';
import { router } from '@inertiajs/vue3';
import axios from 'axios';
import NProgress from 'nprogress';
import Swal from 'sweetalert2'
import Multiselect from 'vue-multiselect'
import 'vue-multiselect/dist/vue-multiselect.css'

const props = defineProps({
    id: Number,
    prodis: Object,
    guruPamongs: Object,
    dpls: Object
})

const form = reactive({
    nama: '',
    username: '',
    email: '',
    role: '',
    prodi: '',
    id_guru_pamong: '',
    id_dpl: ''
})

const disabled = ref(true)
const value = ref('vuex')
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
        prodi: form.prodi,
        id_dpl: form.id_dpl.id,
        id_guru_pamong: form.id_guru_pamong.id
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
    form.username = nama+'-'+prodi
}

const nameWithLang = ({nama}) => {
    return nama
}

const updateValueAction = ({ commit }, value) => {
    commit('updateValue', value)
}
</script>
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
                @change="setUsername(form.nama, form.prodi)"
            />
            <InputError v-if="validation.nama" :message="validation.nama[0]" class="mt-2" />
        </div>

        <div>
            <InputLabel for="username" value="Username" />
            <TextInput
                @change="setUsername(form.nama, form.prodi)"
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
            <SelectInput class="mt-1 w-full" v-model="form.role" :class="{ 'border-rose-600': validation.role }">
                <option selected disabled value="">-- Pilih --</option>
                <option value="1">Admin</option>
                <option value="2">DPL</option>
                <option value="3">Guru Pamong</option>
            </SelectInput>
            <InputError v-if="validation.role" :message="validation.role[0]" class="mt-2" />
        </div>

        <div v-if="form.role == 3">
            <InputLabel for="id_guru_pamong" value="Guru Pamong"/>
            <Multiselect :class="{ 'border-rose-600': validation.id_guru_pamong }" v-model="form.id_guru_pamong" :custom-label="nameWithLang" label="nama" :options="guruPamongs"></Multiselect>
            <InputError v-if="validation.id_guru_pamong" :message="validation.id_guru_pamong[0]" class="mt-2" />
        </div>
        
        <div v-if="form.role == 2">
            <InputLabel for="id_dpl" value="Dpl"/>
            <Multiselect :class="{ 'border-rose-600': validation.id_dpl }" v-model="form.id_dpl" :custom-label="nameWithLang" label="nama" :options="dpls"></Multiselect>
            <InputError v-if="validation.id_dpl" :message="validation.id_dpl[0]" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <PrimaryButton>Save</PrimaryButton>
        </div>
    </form>
</template>