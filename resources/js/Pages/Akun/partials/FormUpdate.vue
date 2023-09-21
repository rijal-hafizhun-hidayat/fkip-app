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
    dpls: Object,
    mahasiswas: Object
})

const form = reactive({
    nama_depan: '',
    nama: '',
    username: '',
    email: '',
    role: '',
    niy: '',
    id_guru_pamong: '',
    id_dpl: '',
    id_mahasiswa: ''
})
const validation = ref([])

onMounted(() => {
    getAkunById()
})

const getAkunById = () => {
    NProgress.start()
    axios.get(`/getAkunById/${props.id}`)
    .then((res) => {
        form.nama_depan = res.data.data.nama_depan
        form.nama = res.data.data.nama
        form.username = res.data.data.username
        form.email = res.data.data.email
        form.role = res.data.data.role
    })
    .catch((err) => {
        console.log(err)
    })
    .finally(() => {
        NProgress.done()
    })
}

const submit = () => {
    NProgress.start()
    axios.put(`/akun/${props.id}`, {
        nama_depan: form.nama_depan,
        nama: form.nama,
        username: form.username,
        email: form.email,
        role: form.role,
        id_dpl: form.id_dpl.id,
        id_guru_pamong: form.id_guru_pamong.id,
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

const isChangeMahasiswa = () => {
    axios.get(`/getMahasiswaById/${form.id_mahasiswa.id}`)
    .then((res) => {
        form.nim = res.data.data.nim
        setUsername()
    })
    .catch((err) => {
        console.log(err)
    })
}

const isChangeDpl = () => {
    axios.get(`/getDplById/${form.id_dpl.id}`)
    .then((res) => {
        form.niy = res.data.data.nipy
    })
    .catch((err) => {
        console.log(err)
    })
}

const setUsername = () => {
    if(form.role == 1){
        form.username = Math.floor(1000 + Math.random() * 9000) + '@admin'
    }
    else if(form.role == 2){
        form.username = Math.floor(1000 + Math.random() * 9000) + '@dpl'
    }
    else if(form.role == 3){
        form.username = Math.floor(1000 + Math.random() * 9000) + '@guru';
    }
    else if(form.role == 4){
        form.username = form.nim + '@mahasiswa'
    }
}

const setJenisPlp = (jenisPlp) => {
    switch(jenisPlp){
        case 'plp_1':
            return 'PLP 1';
            break;
        case 'plp_2':
            return 'PLP 2';
            break;
        case 'km_plp_1':
            return 'Kampus Mengajar (PLP 1)';
            break;
        case 'km_plp_2':
            return 'Kampus Mengajar (PLP 2)';
            break;
        case 'am_plp_2':
            return 'Asistensi Mengajar';
            break;
        default:
            return 'udentified';
            break;
    }
}

const nameMahasiswaWithLang = ({nama, prodi, jenis_plp}) => {
    return `${nama} - ${prodi} - ${setJenisPlp(jenis_plp)}`
}

const nameDplWithLang = ({nama, prodi}) => {
    return `${nama} - ${prodi}`
}

const nameGuruPamongWithLang = ({nama, bidang_keahlian}) => {
    return `${nama} - ${bidang_keahlian}`
}
</script>
<template>
    <form @submit.prevent="submit" class="mt-6 space-y-6">
        <div>
            <InputLabel for="nama_depan" value="Nama Depan" />
            <TextInput
                id="nama_depan"
                ref="nama_depan"
                type="text"
                class="mt-1 block w-full"
                v-model="form.nama_depan"
                @change="setUsername()"
                :class="{ 'border-rose-600': validation.nama_depan }"/>
            <InputError v-if="validation.nama_depan" :message="validation.nama_depan[0]" class="mt-2" />
        </div>
        <div>
            <InputLabel for="nama_lengkap" value="Nama Lengkap" />
            <TextInput
                id="nama"
                ref="nama"
                type="text"
                class="mt-1 block w-full"
                v-model="form.nama"
                @change="setUsername()"
                :class="{ 'border-rose-600': validation.nama }"/>
            <InputError v-if="validation.nama" :message="validation.nama[0]" class="mt-2" />
        </div>

        <div>
            <InputLabel for="email" value="Email" />
            <TextInput
                id="email"
                ref="email"
                type="email"
                class="mt-1 block w-full"
                v-model="form.email"
                @change="setUsername()"
                :class="{ 'border-rose-600': validation.email }"/>
            <InputError v-if="validation.email" :message="validation.email[0]" class="mt-2" />
        </div>

        <div>
            <InputLabel for="role" value="Role"/>
            <SelectInput
                class="mt-1 w-full"
                v-model="form.role"
                :class="{ 'border-rose-600': validation.role }"
                @change="setUsername()">
                <option selected disabled value="">-- Pilih --</option>
                <option value="1">Admin</option>
                <option value="2">DPL</option>
                <option value="3">Guru Pamong</option>
                <option value="4">Mahasiswa</option>
            </SelectInput>
            <InputError v-if="validation.role" :message="validation.role[0]" class="mt-2" />
        </div>

        <div v-if="form.role == 4">
            <InputLabel for="id_mahasiswa" value="Mahasiswa"/>
            <Multiselect
                :class="{ 'border-rose-600': validation.id_mahasiswa }"
                @select="isChangeMahasiswa()"
                v-model="form.id_mahasiswa"
                :custom-label="nameMahasiswaWithLang"
                label="nama"
                :options="mahasiswas">
            </Multiselect>
            <InputError v-if="validation.id_mahasiswa" :message="validation.id_mahasiswa[0]" class="mt-2" />
        </div>

        <div v-if="form.role == 3">
            <InputLabel for="id_guru_pamong" value="Guru Pamong"/>
            <Multiselect
                :class="{ 'border-rose-600': validation.id_guru_pamong }"
                @select="setUsername()"
                v-model="form.id_guru_pamong"
                :custom-label="nameGuruPamongWithLang"
                label="nama"
                :options="guruPamongs">
            </Multiselect>
            <InputError v-if="validation.id_guru_pamong" :message="validation.id_guru_pamong[0]" class="mt-2" />
        </div>
        
        <div v-if="form.role == 2">
            <InputLabel for="id_dpl" value="Dpl"/>
            <Multiselect
                :class="{ 'border-rose-600': validation.id_dpl }"
                @select="isChangeDpl()"
                v-model="form.id_dpl"
                :custom-label="nameDplWithLang"
                label="nama"
                :options="dpls">
            </Multiselect>
            <InputError v-if="validation.id_dpl" :message="validation.id_dpl[0]" class="mt-2" />
        </div>

        <div>
            <InputLabel for="username" value="Username" />
            <TextInput
                id="username"
                ref="username"
                type="text"
                class="mt-1 block w-full"
                v-model="form.username"
                :class="{ 'border-rose-600': validation.username }"/>
            <InputError v-if="validation.username" :message="validation.username[0]" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <PrimaryButton>Save</PrimaryButton>
        </div>
    </form>
</template>