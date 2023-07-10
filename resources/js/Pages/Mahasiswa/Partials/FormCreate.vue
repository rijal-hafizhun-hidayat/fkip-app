<template>
     <form @submit.prevent="submit" class="mt-6 space-y-6">
        <div>
            <InputLabel for="nama" value="Nama Mahasiswa" />
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
                <InputLabel for="nim" value="Nim" />
                <TextInput
                    id="nim"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.nim"
                    v-on:keypress="numOnly"
                    :class="{ 'border-rose-600': validation.nim }"
                />
                <InputError v-if="validation.nim" :message="validation.nim[0]" class="mt-2" />
            </div>

            <div>
                <InputLabel for="prodi" value="Prodi"/>
                <SelectInput class="mt-1 blobk w-full" v-model="form.prodi" :class="{ 'border-rose-600': validation.prodi }">
                    <option selected disabled value="">-- Pilih --</option>
                    <option v-for="prodi in prodis">{{ prodi.nama }}</option>
                </SelectInput>
                <InputError v-if="validation.prodi" :message="validation.prodi[0]" class="mt-2" />
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

            <div class="flex items-center gap-4">
                <PrimaryButton>Save</PrimaryButton>
            </div>
        </form>
</template>
<script>
import { ref, reactive } from 'vue'
import axios from 'axios';
import NProgress from 'nprogress';
import Swal from 'sweetalert2'
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import SelectInput from '@/Components/SelectInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { router } from '@inertiajs/vue3'
export default{
    components: {
        TextInput,
        InputLabel,
        InputError,
        SelectInput,
        PrimaryButton
    },
    props: {
        prodis: Object
    },
    setup(){
        const form = reactive({
            nama: '',
            nim: '',
            email: '',
            prodi: ''
        })

        const validation = ref([])

        const submit = () => {
            NProgress.start()
            axios.post('/mahasiswa', {
                nama: form.nama,
                nim: form.nim,
                email: form.email,
                prodi: form.prodi
            })
            .then((res) => {
                Swal.fire({
                    icon: 'success',
                    title: res.data.title,
                    text: res.data.text
                })

                router.get('/mahasiswa')
            })
            .catch((err) => {
                validation.value = err.response.data.errors
            })
            .finally(() => {
                NProgress.done()
            })
        }

        const numOnly = (evt) => {
            evt = (evt) ? evt : window.event;
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 46) {
                evt.preventDefault();
            } else {
                return true;
            }
        }

        return {
            form,
            validation,
            submit,
            numOnly
        }
    }
}
</script>