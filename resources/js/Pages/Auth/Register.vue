<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import SelectInput from '@/Components/SelectInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import axios from 'axios';
import nprogress from 'nprogress';
import Swal from 'sweetalert2';
import { ref, reactive } from 'vue'
import Multiselect from 'vue-multiselect'
import 'vue-multiselect/dist/vue-multiselect.css'

const validation = ref([])
const form = reactive({
    nama_depan: '',
    nama_lengkap: '',
    nim: '',
    role: '',
    username: '',
    password: '',
    email: '',
    id_mahasiswa: '',
    id_guru_pamong: ''
});
const props = defineProps({
    mahasiswas: Array,
    guru_pamongs: Array
})

const submit = () => {
    nprogress.start()
    axios.post('/register', {
        nama_depan: form.nama_depan,
        nama: form.nama_lengkap,
        username: form.username,
        password: form.password,
        email: form.email,
        role: form.role,
        id_mahasiswa: form.id_mahasiswa.id,
        id_guru_pamong: form.id_guru_pamong.id
    })
    .then((res) => {
        Swal.fire({
            icon: 'success',
            title: res.data.title,
            text: res.data.text
        })
        router.get('/dashboard')
    })
    .catch((err) => {
        validation.value = err.response.data.errors
    })
    .finally(() => {
        nprogress.done()
    })
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

const nameGuruPamongWithLang = ({nama, bidang_keahlian}) => {
    return `${nama} - ${bidang_keahlian}`
}

const setUsernamePassword = () => {
    if(form.role == 3){
        form.username = Math.floor(1000 + Math.random() * 9000) + '@guru';
        form.password = '@guru'
    }
    else if(form.role == 4){
        form.username = form.nim + '@mahasiswa'
        form.password = Math.floor(1000 + Math.random() * 9000) + '@mahasiswa'
    }
}
</script>

<template>
    <GuestLayout>
        <Head title="Register" />

        <form @submit.prevent="submit">
            <div>
                <InputLabel for="nama_depan" value="Nama Depan" />

                <TextInput
                    @change="setUsernamePassword()"
                    id="nama_depan"
                    type="text"
                    class="mt-1 block w-full"
                    :class="{ 'border-rose-600': validation.nama_depan }"
                    v-model="form.nama_depan"
                    autofocus
                    required
                    autocomplete="nama"
                />

                <InputError v-if="validation.nama_depan" class="mt-2" :message="validation.nama_depan[0]" />
            </div>

            <div class="mt-4">
                <InputLabel for="nama_lengkap" value="Nama Lengkap" />

                <TextInput
                    @change="setUsernamePassword()"
                    id="nama_lengkap"
                    type="text"
                    class="mt-1 block w-full"
                    :class="{ 'border-rose-600': validation.nama }"
                    v-model="form.nama_lengkap"
                    autofocus
                    required
                    autocomplete="nama"
                />

                <InputError v-if="validation.nama" class="mt-2" :message="validation.nama[0]" />
            </div>

            <div class="mt-4">
                <InputLabel for="email" value="Email" />

                <TextInput
                    @change="setUsernamePassword()"
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    :class="{ 'border-rose-600': validation.email }"
                    v-model="form.email"
                    autofocus
                    required
                    autocomplete="nama"
                />

                <InputError v-if="validation.email" class="mt-2" :message="validation.email[0]" />
            </div>

            <div class="mt-4">
                <InputLabel for="role" value="Role" />

                <SelectInput
                    @change="setUsernamePassword()"
                    class="mt-1 blobk w-full"
                    :class="{ 'border-rose-600': validation.role }"
                    v-model="form.role"
                    required>
                    <option selected disabled value="">-- Pilih --</option>
                    <option value="3">Guru Pamong</option>
                    <option value="4">Mahasiswa</option>
                </SelectInput>

                <InputError v-if="validation.role" class="mt-2" :message="validation.role[0]" />
            </div>

            <div v-if="form.role == 4" class="mt-4">
                <InputLabel for="nim" value="Nim" />

                <TextInput
                    @change="setUsernamePassword()"
                    id="nim"
                    type="text"
                    class="mt-1 block w-full"
                    :class="{ 'border-rose-600': validation.nim }"
                    v-model="form.nim"
                    required/>

                <InputError v-if="validation.nim" class="mt-2" :message="validation.nim[0]" />

            </div>

            <div v-if="form.role == 4" class="mt-4">
                <InputLabel for="id_mahasiswa" value="Asosiasi Akun dengan Data Mahasiswa"/>
                
                <Multiselect
                    @change="setUsernamePassword()"
                    v-model="form.id_mahasiswa"
                    :custom-label="nameMahasiswaWithLang"
                    :options="mahasiswas"
                    required
                    :class="{ 'border-rose-600': validation.id_mahasiswa }">
                </Multiselect>

                <InputError v-if="validation.id_mahasiswa" class="mt-2" :message="validation.id_mahasiswa[0]" />
            </div>

            <div v-if="form.role == 3" class="mt-4">
                <InputLabel for="id_guru_pamong" value="Asosiasi Akun dengan Data Guru Pamong"/>
                <Multiselect
                    @change="setUsernamePassword()"
                    v-model="form.id_guru_pamong"
                    :custom-label="nameGuruPamongWithLang"
                    :options="guru_pamongs"
                    required>
                </Multiselect>
            </div>

            <div class="mt-4">
                <InputLabel for="username" value="Username" />

                <TextInput
                    id="username"
                    type="text"
                    class="mt-1 block w-full bg-slate-200"
                    :class="{ 'border-rose-600': validation.username }"
                    v-model="form.username"
                    disabled
                    autocomplete="username"
                    required />

                <InputError v-if="validation.username" class="mt-2" :message="validation.username[0]" />
            </div>

            <div class="mt-4">
                <InputLabel for="password" value="Password" />

                <TextInput
                    id="password"
                    type="text"
                    class="mt-1 block w-full bg-slate-200"
                    :class="{ 'border-rose-600': validation.password }"
                    v-model="form.password"
                    disabled
                    required
                    autocomplete="new-password"
                />

                <InputError v-if="validation.password" class="mt-2" :message="validation.password[0]" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <Link
                    :href="route('login')"
                    class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                    Already registered?
                </Link>

                <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Register
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>