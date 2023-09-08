<script setup>
import { ref, reactive } from 'vue'
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

const form = reactive({
    nama: '',
    username: '',
    password: '',
    email: '',
    role: '',
    nim: '',
    niy: '',
    id_guru_pamong: '',
    id_dpl: '',
    id_mahasiswa: ''
})
const validation = ref([])
const isSeePass = ref(false)
const props = defineProps({
    guruPamongs: Object,
    prodis: Object,
    dpls: Object,
    mahasiswas: Object
})

const submit = () => {
    NProgress.start()
    axios.post('/akun', {
        nama_depan: form.nama_depan,
        nama: form.nama,
        username: form.username,
        password: form.password,
        email: form.email,
        role: form.role,
        id_guru_pamong: form.id_guru_pamong.id,
        id_dpl: form.id_dpl.id,
        id_mahasiswa: form.id_mahasiswa.id
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

const isChangeDpl = () => {
    axios.get(`/getDplById/${form.id_dpl.id}`)
    .then((res) => {    
        form.niy = res.data.data.nipy
        setUsernamePassword()
    })
    .catch((err) => {
        console.log(err)
    })
}

const isChangeMahasiswa = () => {
    axios.get(`/getMahasiswaById/${form.id_mahasiswa.id}`)
    .then((res) => {
        form.nim = res.data.data.nim
        setUsernamePassword()
    })
    .catch((err) => {
        console.log(err)
    })
}

const setUsernamePassword = () => {
    if(form.role == 1){
        form.username = Math.floor(1000 + Math.random() * 9000) + '@admin'
        form.password = Math.floor(1000 + Math.random() * 9000) + '@admin'
    }
    else if(form.role == 2){
        form.username = Math.floor(1000 + Math.random() * 9000) + '@dpl'
        form.password = '@dpl'
    }
    else if(form.role == 3){
        form.username = Math.floor(1000 + Math.random() * 9000) + '@guru'
        form.password = '@guru'
    }
    else if(form.role == 4){
        form.username = form.nim + '@mahasiswa'
        form.password = Math.floor(1000 + Math.random() * 9000) + '@mahasiswa'
    }
}

const nameMahasiswaWithLang = ({nama}) => {
    return nama
}

const nameDplWithLang = ({nama}) => {
    return nama
}

const nameGuruPamongWithLang = ({nama, bidang_keahlian}) => {
    return `${nama} - ${bidang_keahlian}`
}
</script>
<template>
    <form @submit.prevent="submit" class="space-y-6">
        <div>
            <InputLabel for="nama_depan" value="Nama Depan" />
            <TextInput
                id="nama"
                type="text"
                class="mt-1 block w-full"
                v-model="form.nama_depan"
                @change="setUsernamePassword"
                required
                :class="{ 'border-rose-600': validation.nama_depan }"/>
            <InputError v-if="validation.nama_depan" :message="validation.nama_depan[0]" class="mt-2" />
        </div>

        <div>
            <InputLabel for="nama" value="Nama Lengkap" />
            <TextInput
                id="nama"
                type="text"
                class="mt-1 block w-full"
                v-model="form.nama"
                @change="setUsernamePassword"
                required
                :class="{ 'border-rose-600': validation.nama }"/>
            <InputError v-if="validation.nama" :message="validation.nama[0]" class="mt-2" />
        </div>

        <div>
            <InputLabel for="email" value="Email" />
            <TextInput
                id="email"
                type="email"
                class="mt-1 block w-full"
                v-model="form.email"
                @change="setUsernamePassword"
                :class="{ 'border-rose-600': validation.email }"/>
            <InputError v-if="validation.email" :message="validation.email[0]" />
        </div>

        <div>
            <InputLabel for="role" value="Role" />
            <SelectInput
                class="mt-1 blobk w-full"
                v-model="form.role"
                @change="setUsernamePassword"
                :class="{ 'border-rose-600': validation.role }"
                required>
                <option selected disabled value="">-- Pilih --</option>
                <option value="1">Admin</option>
                <option value="2">DPL</option>
                <option value="3">Guru Pamong</option>
                <option value="4">Mahasiswa</option>
                <option value="5">DKL</option>
            </SelectInput>
            <InputError v-if="validation.role" :message="validation.role[0]" class="mt-2" />
        </div>

        <div v-if="form.role == 4">
            <InputLabel for="id_mahasiswa" value="Mahasiswa"/>
            <Multiselect
                v-model="form.id_mahasiswa"
                @select="isChangeMahasiswa"
                :custom-label="nameMahasiswaWithLang"
                :options="mahasiswas">
            </Multiselect>
            <InputError v-if="validation.id_guru_pamong" :message="validation.id_guru_pamong[0]" class="mt-2" />
        </div>

        <div v-if="form.role == 3">
            <InputLabel for="id_guru_pamong" value="Guru Pamong"/>
            <Multiselect
                v-model="form.id_guru_pamong"
                :custom-label="nameGuruPamongWithLang"
                :options="guruPamongs">
            </Multiselect>
            <InputError v-if="validation.id_guru_pamong" :message="validation.id_guru_pamong[0]" class="mt-2" />
        </div>

        <div v-if="form.role == 2">
            <InputLabel for="id_dpl" value="Dpl"/>
            <Multiselect
                v-model="form.id_dpl"
                @select="isChangeDpl"
                :custom-label="nameDplWithLang"
                :options="dpls">
            </Multiselect>
            <InputError v-if="validation.id_dpl" :message="validation.id_dpl[0]" class="mt-2" />
        </div>
                    
        <div>
            <InputLabel for="username" value="Username" />
            <TextInput
                disabled
                required
                id="username"
                ref="username"
                type="text"
                class="mt-1 block w-full bg-slate-200"
                v-model="form.username"
                :class="{ 'border-rose-600': validation.username }" />
            <InputError v-if="validation.username" :message="validation.username[0]" class="mt-2" />
        </div>

        <div>
            <InputLabel for="password" value="Password" />
            <div class="flex flex-row">
                <div class="basis-full">
                    <TextInput
                        id="password"
                        disabled
                        required
                        :type="isSeePass == false ? 'password' : 'text'"
                        class="mt-1 block w-full bg-slate-200"
                        v-model="form.password"
                        :class="{ 'border-rose-600': validation.password }" />
                    <InputError v-if="validation.password" :message="validation.password[0]" class="mt-2" />
                </div>
                <div class="ml-3">
                    <PrimaryButton v-if="isSeePass == true" class="mt-1 py-3.5" @click="isSeePass = !isSeePass"><i class="fa-solid fa-eye-slash"></i></PrimaryButton>
                    <PrimaryButton v-if="isSeePass == false" class="mt-1 py-3.5" @click="isSeePass = !isSeePass"><i class="fa-solid fa-eye"></i></PrimaryButton>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-4">
            <PrimaryButton>Save</PrimaryButton>
        </div>
    </form>
</template>