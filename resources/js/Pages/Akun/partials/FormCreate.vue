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
    role: '',
    nim: '',
    id_guru_pamong: '',
    id_dpl: '',
    id_mahasiswa: ''
})

const disabled = ref(true)
const validation = ref([])
const isSeePass = ref(false)
const asosiasi = ref([])
// const hiddenPass = ref('fa-solid fa-eye-slash fa-lg')
// const showPass = ref('fa-solid fa-eye fa-lg')
const props = defineProps({
    guruPamongs: Object,
    prodis: Object,
    dpls: Object,
    mahasiswas: Object
})

const submit = () => {
    //console.log(form)
    NProgress.start()
    axios.post('/akun', {
        nama: form.nama,
        username: form.username,
        password: form.password,
        role: form.role,
        id_guru_pamong: form.id_guru_pamong,
        id_dpl: form.id_dpl,
        id_mahasiswa: form.id_mahasiswa
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

const setIdDplGuruPamong = (role, uniq) => {
    console.log(uniq.idq)
    if(role == 2){
        form.id_dpl = uniq.id
        form.id_guru_pamong = null
        form.id_mahasiswa = null
    }
    else if(role == 3){
        form.id_dpl = null
        form.id_guru_pamong = uniq.id
        form.id_mahasiswa = null
    }
    else if(role == 4){
        form.id_dpl = null
        form.id_guru_pamong = null
        form.id_mahasiswa = uniq.id
    }
    else{
        form.id_dpl = null
        form.id_guru_pamong = null
        form.id_mahasiswa = null
    }
}

const setUsername = (firstName, role, singkatanProdi, bidang_keahlian) => {
    if(role == 2){
        form.username = firstName.toLowerCase()+'-'+singkatanProdi
    }
    else if(role == 3){
        form.username = firstName.toLowerCase()+'-'+bidang_keahlian.toLowerCase()
    }
    else{
        form.username = firstName+Math.floor(Math.random()*(999-100+1)+100)+'@admin'
    }
}

const setPassword = (firstName, role, uniq) => {
    if(role == 2){
        //form.password = firstName.toLowerCase()+uniq.nipy
        form.password = firstName.toLowerCase()+Math.floor(Math.random() * 9000 + 1000);
    }
    else if(role == 3){
        //form.password = firstName.toLowerCase()+uniq.bidang_keahlian.toLowerCase()+Math.floor(Math.random()*(999-100+1)+100)
        form.password = firstName.toLowerCase()+Math.floor(Math.random() * 9000 + 1000)+'@admin';
    }
    else if(role == 1){
        form.password = Math.floor(Math.random()*(999-100+1)+100)+'@admin'
    }
    else{
        form.password = Math.floor(Math.random() * 9000 + 1000)+'@admin'
    }
}

const setUsernamePasswordIdDplGuruPamong = (nama, role, uniq) => {
    let firstName = nama.split(" ")[0]
    let prodiBidangKeahlian = role == 2 ? uniq.prodi : uniq.bidang_keahlian
    if(role == 2 || role == 3){
        axios.get(`/getProdi/${prodiBidangKeahlian}`)
        .then((res) => {
            setUsername(firstName, role, res.data.data.singkatan, uniq.bidang_keahlian)
            setPassword(firstName, role, uniq)
            setIdDplGuruPamong(role, uniq)
        })
        .catch((err) => {
            console.log(err)
        })
    }
    else if(role == 1){
        form.username = firstName.toLowerCase()+Math.floor(Math.random()*(999-100+1)+100)+'@admin'
        form.password = Math.floor(Math.random()*(999-100+1)+100)+'@admin'
    }
    else{
        form.username = firstName.toLowerCase()+uniq.nim
        form.password = Math.floor(100000 + Math.random() * 900000)+'@mahasiswa'
        setIdDplGuruPamong(role, uniq)
    }
}

const nameWithLang = ({nama}) => {
    return nama
}
</script>
<template>
    <form @submit.prevent="submit" class="space-y-6">
        <div>
            <InputLabel for="nama" value="Nama" />
            <TextInput
                id="nama_depan"
                type="text"
                class="mt-1 block w-full"
                v-model="form.nama"
                :class="{ 'border-rose-600': validation.nama }"
                @change="setUsernamePasswordIdDplGuruPamong(form.nama, form.role, asosiasi)" />
            <InputError v-if="validation.nama" :message="validation.nama[0]" class="mt-2" />
        </div>

        <div>
            <InputLabel for="role" value="Role" />
            <SelectInput
                @change="setUsernamePasswordIdDplGuruPamong(form.nama, form.role, asosiasi)"
                class="mt-1 blobk w-full"
                v-model="form.role"
                :class="{ 'border-rose-600': validation.role }">
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
                @select="setUsernamePasswordIdDplGuruPamong(form.nama, form.role, asosiasi)"
                v-model="asosiasi"
                :custom-label="nameWithLang"
                :options="mahasiswas">
            </Multiselect>
            <InputError v-if="validation.id_guru_pamong" :message="validation.id_guru_pamong[0]" class="mt-2" />
        </div>

        <div v-if="form.role == 3">
            <InputLabel for="id_guru_pamong" value="Guru Pamong"/>
            <Multiselect
                @select="setUsernamePasswordIdDplGuruPamong(form.nama, form.role, asosiasi)"
                v-model="asosiasi"
                :custom-label="nameWithLang"
                :options="guruPamongs">
            </Multiselect>
            <InputError v-if="validation.id_guru_pamong" :message="validation.id_guru_pamong[0]" class="mt-2" />
        </div>

        <div v-if="form.role == 2">
            <InputLabel for="id_dpl" value="Dpl"/>
            <Multiselect
                @select="setUsernamePasswordIdDplGuruPamong(form.nama, form.role, asosiasi)"
                v-model="asosiasi"
                :custom-label="nameWithLang"
                :options="dpls">
            </Multiselect>
            <InputError v-if="validation.id_dpl" :message="validation.id_dpl[0]" class="mt-2" />
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
                :class="{ 'border-rose-600': validation.username, 'bg-slate-200': disabled }" />
            <InputError v-if="validation.username" :message="validation.username[0]" class="mt-2" />
        </div>

        <div>
            <InputLabel for="password" value="Password" />
            <div class="flex flex-row">
                <div class="basis-full">
                    <TextInput
                        id="password"
                        :type="isSeePass == false ? 'password' : 'text'"
                        class="mt-1 block w-full"
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